<?php

namespace App\Services;

use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\SearchObjects\ProductSearchObject;
use App\Models\Enums\ProductState;
use App\Models\Product;
use App\Models\ProductStateMachine\States\BaseState;
use App\Services\Contracts\ProductServiceInterface;
use Exception;

class ProductService extends BaseService implements ProductServiceInterface
{

    public function __construct(protected BaseState $baseState)
    {
    }

    public function addFilter($searchObject, $query)
    {
        return $query
            ->when($searchObject->name, fn ($q, $name) => $q->where('name', $name))
            ->when($searchObject->validFrom, fn ($q, $validFrom) => $q->where('validFrom', '>=', $validFrom))
            ->when($searchObject->validTo, fn ($q, $validTo) => $q->where('validTo', '<=', $validTo))
            ->when($searchObject->greatestPrice || $searchObject->lowestPrice, function ($q) use ($searchObject) {
                $q->whereHas('variants', function ($variantQuery) use ($searchObject) {
                    $variantQuery
                        ->when($searchObject->greatestPrice, fn ($q, $price) => $q->where('price', '>', $price))
                        ->when($searchObject->lowestPrice, fn ($q, $price) => $q->where('price', '<', $price));
                });
            });
    }

    public function includeRelation($searchObject, $query)
    {
        if ($searchObject->includeProductType) {
            $query = $query->with('productType');
        }

        return $query;
    }

    protected function getModelClass()
    {
        return Product::class;
    }

    public function allowedActions(int $id)
    {
        $product = Product::find($id);
        $state = $this->baseState->getState($product->state);

        return $state->allowedActions();
    }

    public function getInsertRequestClass()
    {
        return ProductAddRequest::class;
    }

    public function getUpdateRequestClass()
    {
        return ProductUpdateRequest::class;
    }

    public function add($request)
    {
        $state = BaseState::getState(ProductState::DRAFT->value);

        return $state->addProduct($request->all());
    }

    public function insert($request)
    {
        $model = Product::create($request);
        return $model;
    }

    public function addVariant(array $request)
    {
        $model = Product::find($request['product_id']);

        $state = BaseState::getState($model->status);

        return $state->addVariant($request);
    }

    public function activate($id, array $request)
    {
        $model = Product::find($id);

        $state = BaseState::getState($model->status);

        return $state->activate($request, $model);
    }

    public function hideProduct($id)
    {
        $product = Product::find($id);

        $state = BaseState::getState($product->status);

        return $state->hideProduct($product);
    }

    public function draftProduct($id)
    {
        $model = Product::find($id);
        $state = BaseState::getState($model->status);
        return $state->productDraft($id);
    }

    public function update(Request $request, int $id)
    {
        $model = Product::find($id);

        if (!$model) {
            throw new Exception("Resource not found!");
        }

        $state = BaseState::getState($model->status);

        return $state->updateProduct($id, $request);
    }

    public function updateProduct($request, int $id)
    {
        $model = Product::find($id);

        if (!$model) {
            throw new Exception("Resource not found!");
        }

        $model->update($request->all());
        return $model;
    }
}

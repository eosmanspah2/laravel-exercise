<?php

namespace App\Services;

use App\Http\Requests\SearchObjects\ProductSearchObject;
use App\Models\Enums\ProductState;
use App\Models\Product;
use App\Models\ProductStateMachine\States\BaseState;
use App\Services\Contracts\ProductServiceInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
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

    public function getSearchObject()
    {
        return ProductSearchObject::class;
    }

    protected function getModelClass()
    {
        return Product::class;
    }

    //TO FIX + allowed actions
    public function activate(Product $product)
    {
        $productState = BaseState::getState($product->state);
        $productState->moveToNextState($product, ProductState::ACTIVE);
    }

    public function draft(Product $product)
    {
        $productState = BaseState::getState($product->state);
        $productState->moveToNextState($product, ProductState::DRAFT);
    }

    public function deleted(Product $product)
    {
        $productState = BaseState::getState($product->state);
        $productState->moveToNextState($product, ProductState::DRAFT);
    }
}

<?php

namespace App\Services;

use App\Http\Requests\SearchObjects\ProductSearchObject;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function addFilter($searchObject, $query){

        if ($searchObject->name) {
            $query = $query->where('name', $searchObject->name);
        }
        if ($searchObject->priceGT || $searchObject->priceLT) {
            $query = $query->whereHas('variants', function ($variantQuery) use ($searchObject) {
                if ($searchObject->greatestPrice) {
                    $variantQuery->where('price', '>', $searchObject->greatestPrice);
                }
                if ($searchObject->lowestPrice) {
                    $variantQuery->where('price', '<', $searchObject->lowestPrice);
                }
            });
        }

        return $query;
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
}

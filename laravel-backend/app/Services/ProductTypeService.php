<?php

namespace App\Services;

use App\Http\Requests\SearchObjects\ProductSearchObject;
use App\Http\Requests\SearchObjects\ProductTypeSearchObject;
use App\Models\ProductType;

class ProductTypeService extends BaseService
{
    public function addFilter($searchObject, $query)
    {

        return $query;
    }

    public function includeRelation($searchObject, $query)
    {

        return $query;
    }

    protected function getModelClass()
    {
        return ProductType::class;
    }
}

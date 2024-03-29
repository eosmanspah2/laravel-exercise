<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductTypeCreateRequest;
use App\Http\Requests\ProductTypeUpdateRequest;
use App\Http\Requests\SearchObjects\ProductTypeSearchObject;
use App\Http\Resources\ProductTypeResource;
use App\Services\Contracts\ProductTypeServiceInterface;

class ProductTypeController extends BaseController
{
    public function __construct(ProductTypeServiceInterface $productTypeService)
    {
        parent::__construct($productTypeService);
    }

    public function getInsertRequestClass()
    {
        return ProductTypeCreateRequest::class;
    }

    public function getUpdateRequestClass()
    {
        return ProductTypeUpdateRequest::class;
    }

    public function getAllResourcePayload($data, $collection = false): mixed
    {
        if ($collection) {
            return ProductTypeResource::collection($data);
        }

        return new ProductTypeResource($data);
    }

    public function getSearchObject($params)
    {
        return new ProductTypeSearchObject($params);
    }
}

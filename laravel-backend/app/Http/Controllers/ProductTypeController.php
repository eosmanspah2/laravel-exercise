<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductTypeCreateRequest;
use App\Http\Requests\ProductTypeUpdateRequest;
use App\Http\Resources\ProductTypeResource;
use App\Services\Interfaces\ProductTypeServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function getAllResourcePayload($request, $collection = false) : ProductTypeResource | AnonymousResourceCollection
    {
        if($collection)
        {
            return ProductTypeResource::collection($request);
        }

        return new ProductTypeResource($request);
    }
}

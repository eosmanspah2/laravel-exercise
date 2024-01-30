<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductInsertRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends BaseController
{
    public function __construct(ProductServiceInterface $productService)
    {
        parent::__construct($productService);
    }

    public function getInsertRequestClass()
    {
        return ProductInsertRequest::class;
    }

    public function getUpdateRequestClass()
    {
        return ProductUpdateRequest::class;
    }

    public function getAllResourcePayload($request, $collection = false) : ProductResource | AnonymousResourceCollection
    {
        if($collection)
        {
            return ProductResource::collection($request);
        }

        return new ProductResource($request);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends BaseController
{
    protected ProductService $productService;
    public function __construct(ProductServiceInterface $productService)
    {
        parent::__construct($productService);
        $this->productService = $productService;
    }

    public function getInsertRequestClass()
    {
        return ProductAddRequest::class;
    }

    public function getUpdateRequestClass()
    {
        return ProductUpdateRequest::class;
    }

    public function getAllResourcePayload($request, $collection = false): ProductResource | AnonymousResourceCollection
    {
        if ($collection) {
            return ProductResource::collection($request);
        }

        return new ProductResource($request);
    }

    public function newestVariant()
    {
        $productsWithNewestVariant = Product::with(['variants' => function ($query) {
            $query->latest()->limit(1);
        }])->get();

        $structuredData = $productsWithNewestVariant->map(function ($product) {
            $newestVariant = $product->variants->first();
            return [
                'product_id' => $product->id,
                'name' => $product->name,
                'variant_id' => optional($newestVariant)->id,
                'variant_name' => optional($newestVariant)->name,
                'variant_price' => optional($newestVariant)->price,
            ];
        });
        return response()->json(['data' => $structuredData]);
    }

    public function activate(Product $product){
        $this->productService->activate($product);;
    }

    public function draft(Product $product){
        $this->productService->draft($product);
    }

    public function delete(Product $product){
        $this->productService->deleted($product);
    }
}

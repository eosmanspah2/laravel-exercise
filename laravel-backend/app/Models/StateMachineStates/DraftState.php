<?php

namespace App\Models\ProductStateMachine\States;

use App\Models\Enums\ProductActions;
use App\Models\Enums\ProductState;
use App\Services\ProductService;
use App\Services\VariantService;

class DraftState extends BaseState
{

    public function __construct(protected ProductService $productService, protected VariantService $variantService)
    {
        parent::__construct($productService, $variantService);
    }

    public function allowedActions()
    {
        $allowedActions = array();
        array_push($allowedActions, ProductActions::DraftToActive);
        return $allowedActions;
    }

    public function addProduct($request)
    {
        $request['status'] = ProductState::DRAFT;
        $product = $this->productService->insert($request);
        return $product;
    }

    public function updateProduct($id, $request)
    {
        $product = $this->productService->updateProduct($request, $id);
        return $product;
    }

    public function addVariant($request)
    {
        $variant = $this->variantService->insert($request);
        return $variant;
    }

    public function activate($request, $product)
    {
        $product->update([
            'status' => ProductState::ACTIVE->value,
            'valid_from' => $request['valid_from'],
            'valid_to' => $request['valid_to']
        ]);

        return $product;
    }
}

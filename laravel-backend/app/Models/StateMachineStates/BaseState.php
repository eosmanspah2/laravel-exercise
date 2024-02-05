<?php

namespace App\Models\ProductStateMachine\States;

use App\Services\ProductService;
use App\Services\VariantService;
use Exception;

class BaseState
{

    public function __construct(protected ProductService $productService, protected VariantService $variantService)
    {
    }

    public function allowedActions()
    {
        $allowedActions = array();
        return $allowedActions;
    }

    public function addProduct($request)
    {
        throw new Exception("Not allowed");
    }

    public function updateProduct(int $id, $request)
    {
        throw new Exception("Not allowed action");
    }

    public function hideProduct($product)
    {
        throw new Exception("Not allowed action");
    }

    public function activate($request, $model)
    {
        throw new Exception("Not allowed action");
    }

    public function productDraft(int $productId)
    {
        throw new Exception("Not allowed action");
    }

    public function addVariant($request)
    {
        throw new Exception("Not allowed action");
    }


    public static function getState(string $stateName)
    {
        switch ($stateName) {
            case 'ACTIVE':
                return app('ActiveState');
            case 'DRAFT':
                return app('DraftState');
            case 'DELETED':
                return app('DeletedState');
            default:
                throw new Exception("Not allowed action state!");
        }
    }
}

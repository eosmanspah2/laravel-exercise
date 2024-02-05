<?php

namespace App\Models\ProductStateMachine\States;

use App\Models\Enums\ProductActions;
use App\Models\Enums\ProductState;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\VariantService;
use Illuminate\Http\Request;

class ActiveState extends BaseState
{

    public function __construct(protected ProductService $productService, protected VariantService $variantService)
    {
        parent::__construct($productService, $variantService);
    }

    public function allowedActions()
    {
        $allowedActions = array();
        array_push($allowedActions, ProductActions::ActiveToDelete);
        array_push($allowedActions, ProductActions::ActiveToDraft);
        return $allowedActions;
    }

    public function hideProduct($product)
    {
        $product->update([
            'status' => ProductState::DELETED->value
        ]);

        return $product;
    }
}

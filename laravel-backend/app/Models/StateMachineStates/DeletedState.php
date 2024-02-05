<?php

namespace App\Models\ProductStateMachine\States;

use App\Services\ProductService;
use App\Services\VariantService;

class DeletedState extends BaseState
{

    public function __construct(protected ProductService $productService, protected VariantService $variantService)
    {
        parent::__construct($productService, $variantService);
    }

    public function allowedActions()
    {
        $allowedActions = array();
        return $allowedActions;
    }
}

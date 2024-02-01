<?php

namespace App\Models\ProductStateMachine\States;

use App\Models\Enums\ProductState;
use App\Models\Product;
use Illuminate\Http\Request;

class DeletedState extends BaseState{

    public function allowedStates(){
        $list = parent::allowedStates();
        array_push($list, ProductState::ACTIVE, ProductState::DRAFT);
        return $list;
    }

    public function moveToNextState(Product $product, ProductState $productState, $dataToUpdate = null){
        parent::moveToNextState($product, $productState, $dataToUpdate);
    }
}

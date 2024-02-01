<?php

namespace App\Models\ProductStateMachine\States;

use App\Models\Enums\ProductState;
use App\Models\Product;
use Illuminate\Http\Request;

class ActiveState extends BaseState{

    public function allowedStates(){
        $list = parent::allowedStates();
        array_push($list, ProductState::DRAFT, ProductState::DELETED);
        return $list;
    }
    public function moveToNextState(Product $product, ProductState $productState, $dataToUpdate = null){
        parent::moveToNextState($product, $productState, $dataToUpdate);
    }
}

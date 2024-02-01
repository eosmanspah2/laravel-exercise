<?php

namespace App\Models\ProductStateMachine\States;

use App\Models\Enums\ProductState;
use App\Models\Product;

class BaseState
{

    public function allowedStates()
    {
        return [];
    }

    public function moveToNextState(Product $product, ProductState $productState, $dataToUpdate = null)
    {
        $product->refresh();

        $updateData = [
            'state' => $productState,
            'activatedBy' => auth()->id(),
        ];
    
        if (!is_null($dataToUpdate)) {
            $updateData = array_merge($updateData, $dataToUpdate);
        }
    
        $product->update($updateData);
    
        return $product;
    }

    public static function getState(string $stateName)
    {
        switch ($stateName) {
            case 'ACTIVE':
                return new ActiveState();
            case 'DRAFT':
                return new DraftState();
            case 'DELETED':
                return new DeletedState();
        }
    }
}

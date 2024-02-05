<?php
namespace App\StateMachine\Config;

use App\Models\Enums\ProductState;
use App\Models\ProductStateMachine\States\DraftState;
use App\Models\ProductStateMachine\States\ActiveState;
use App\Models\ProductStateMachine\States\DeletedState;

class StateConfiguration
{
    private DraftState $draftState;
    private ActiveState $activatedState;
    private DeletedState $deletedState;

    public function __construct(DraftState $draftState, ActiveState $activatedState, DeletedState $deletedState)
    {
        $this->draftState = $draftState;
        $this->activatedState = $activatedState;
        $this->deletedState = $deletedState;
    }

    /**
     * Get the state map for product statuses.
     *
     * @return array<string, DraftState|ActiveState|DeletedState>
     */
    public function getStateMap(): array
    {
        return [
            ProductState::DRAFT->name => $this->draftState,
            ProductState::ACTIVE->name => $this->activatedState,
            ProductState::DELETED->name => $this->deletedState,
        ];
    }
}

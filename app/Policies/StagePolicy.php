<?php

namespace App\Policies;

use App\Models\Itinerary;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StagePolicy
{
    /**
     * Determine whether the user can edit (create, delete, update) stages.
     */
    public function edit(User $user, Itinerary $itinerary): bool
    {
        if($user->id === $itinerary->user_id)
            return true;
        else
            return false;
    }
}

<?php

namespace App\Policies;

use App\Enum\Visibility;
use App\Models\Itinerary;
use App\Models\User;

class ItineraryPolicy
{
    public function view(?User $user, Itinerary $itinerary): bool
    {
        if ($itinerary->visibility === Visibility::PUBLIC)
            return true;
        else
            return $user && $user->id === $itinerary->user_id;
    }

    public function isOwner(User $user, Itinerary $itinerary): bool
    {
        return $user->id === $itinerary->user_id;
    }
}

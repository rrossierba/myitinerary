<?php

namespace App\Policies;

use App\Enum\Visibility;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItineraryPolicy
{
    public function view(?User $user, Itinerary $itinerary)
    {
        if ($itinerary->visibility === Visibility::PUBLIC)
            return Response::allow();
        else if ($user && $user->id === $itinerary->user_id)
            return Response::allow();
        else
            return Response::denyWithStatus(403);
    }

    public function isOwner(User $user, Itinerary $itinerary)
    {
        return $user->id === $itinerary->user_id 
        ? Response::allow() 
        : Response::denyWithStatus(403);
    }
    
    public function owns(User $user, Itinerary $itinerary): bool
    {
        return $user->id === $itinerary->user_id;
    }

    public function isPublic(?User $user, Itinerary $itinerary): bool
    {
        return $itinerary->visibility===Visibility::PUBLIC;
    }
}

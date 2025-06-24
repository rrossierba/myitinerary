<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->title,
            'owner'=>$this->user->name,
            'visiblity'=>$this->visibility,
            'city'=>new CityResource($this->city),
            'stages' => StageResource::collection($this->stages),
        ];
    }
}

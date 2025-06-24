<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'location'=>$this->location,
            'description'=>$this->description,
            'duration'=>(int)$this->duration,
            'cost'=>(double)$this->cost,
        ];
    }
}

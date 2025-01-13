<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // this is better to return the date and time in any format (human or datetime)
        return [
            'human' => $this->diffForHumans(),
            'datetime' => $this->toDateTimeString()
        ];
    }
}

<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'contact_email' => $this->contact_email,
            'rewards' => RewardResource::collection($this->whenLoaded('rewards')),
            'author' => new PublicUserResource($this->whenLoaded('author'))
        ];
    }
}

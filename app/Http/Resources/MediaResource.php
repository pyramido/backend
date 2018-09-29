<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'name' => $this->name,
            'file_name' => $this->file_name,
            'size' => $this->size,
            'human_readable_size' => $this->human_readable_size,
            'responsive_images' => $this->responsive_images,
            'order' => $this->order_column,
            'url' => $this->getFullUrl()
        ];
    }
}

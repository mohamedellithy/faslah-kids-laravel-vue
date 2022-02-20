<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ImageResource;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'image'       => ($this->images->first() ? new ImageResource($this->images->first()) : ''),
            'description' => $this->description,
            'allow'       => ($this->allow == 1 ? 'published' : 'pending'),
            'kids_id'     => $this->who_buy_product,
            'kids_images' => ImageResource::collection($this->image_for_who_buy_product)
        ];
    }
}

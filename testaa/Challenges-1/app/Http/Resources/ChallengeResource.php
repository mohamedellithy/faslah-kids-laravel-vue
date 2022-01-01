<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        # return parent::toArray($request);
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'image' => ($this->images->first() ? new ImageResource($this->images->first()) : ''),
            'description' => $this->description,
            'allow'  => ($this->allow == 1 ? 'published' : 'pending'),
            'barcode'=> new BarcodeResource($this->barcode),
        ];
    }
}
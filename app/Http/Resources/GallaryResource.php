<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class GallaryResource extends JsonResource
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
            'src'      => asset('storage/'.$this->image_url),
            'thumbSrc' => asset('storage/'.$this->image_url),
            'w'        => 1600,
            'h'        => 1600
        ];
    }
}

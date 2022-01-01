<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChallengesSolutionsResource extends JsonResource
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
            'id'               => $this->id,
            'title'            => $this->challenge->title,
            'product_id'       => $this->challenge->product->id,
            'product_title'    => $this->challenge->product->title,
            'challenge_id'     => $this->challenge->id,
            'images'           => ($this->images ? GallaryResource::collection($this->images) : []),
            'description'      => $this->description,
            'kidname'          => $this->kid->firstname.' '.$this->kid->lastname,
            'email'            => $this->kid->email,
            'count_challenges' =>$this->kid->challenges->count(),
            'kid_id'           => $this->kid_id,
            'age'              => $this->kid->age,
            'kid_images'       => ($this->kid->images->first ? new ImageResource($this->kid->images->first()) : []),
        ];
    }
}

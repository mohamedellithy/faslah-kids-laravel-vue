<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SolutionsResource extends JsonResource
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
            'kidname'     => $this->kids[0]->firstname.' '.$this->kids[0]->lastname,
            'solution'    => $this->kids[0]->pivot,
            'kidimage'    => ($this->kids[0]->images->first() ? new ImageResource($this->kids[0]->images->first()) : [])
        ];
    }
}

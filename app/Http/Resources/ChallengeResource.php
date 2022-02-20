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
            'id'          => $this->id,
            'title'       => $this->title,
            'image'       => ($this->images->first() ? new ImageResource($this->images->first()) : ''),
            'description' => $this->description,
            'allow'       => ($this->allow == 1 ? 'published' : 'pending'),
            'product_id'  => new ProductResource($this->product),
            'number'      => $this->number,
            'count_challenger' =>$this->kids()->count(),
            'images_kids' => ImageResource::collection($this->image_for_who_take_challenge),
            'created_at'=> date('Y-m-d H:i:s',strtotime($this->created_at)),
            'my_solution' => auth()->user() ? auth()->user()->solutions()->where('challenge_id',$this->id)->first() : null
        ];
    }
}

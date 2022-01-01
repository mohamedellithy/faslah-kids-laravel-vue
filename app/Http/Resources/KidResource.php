<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChallengeResource;
class KidResource extends JsonResource
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
            'id'        => $this->id,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'name'      => $this->firstname.' '.$this->firstname,
            'image'     => ($this->images->first() ? new ImageResource($this->images->first()) : []),
            'age'       => $this->age,
            'email'     => $this->email,
            'fullname'  => $this->firstname.' '.$this->lastname,
            'challenges'=> ChallengeResource::collection($this->challenges),
            'count_challenges' => $this->challenges->count(),
            'role'      => $this->role
        ];
    }
}

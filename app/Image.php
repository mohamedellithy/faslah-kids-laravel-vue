<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = ['imageable_id','imageable_type','image_url'];

    /**
     * Get the parent commentable model (products or challenges or users and more).
     */
    public function Imageable()
    {
        return $this->morphTo();
    }
}

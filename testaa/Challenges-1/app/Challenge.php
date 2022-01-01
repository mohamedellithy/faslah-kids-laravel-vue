<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    //
     protected $fillable = ['title','description','allow','barcode_id'];
    /**
     * Get all of the post's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function barcode(){
       return $this->belongsTo('App\Barcode','barcode_id','id');
    }
}

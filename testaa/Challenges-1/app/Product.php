<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['title','description','allow'];
    /**
     * Get all of the post's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function barcodes(){
       return $this->hasMany('App\Barcode','item_id','id');
    }
}

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

    public function getWhoBuyProductAttribute(){
       // who_buy_product
       return $this->barcodes->where('activated',1)->pluck('kid_id')->toArray();
    }

    public function getImageForWhoBuyProductAttribute(){
       // image_for_who_buy_product
       return Image::whereIn('imageable_id',$this->who_buy_product)->where('imageable_type','App\User')->limit(8)->get();
    }
}

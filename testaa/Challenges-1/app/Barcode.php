<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    //

    public function Product(){
        return $this->belongsTo('App\Product','item_id','id');
    }
    public function challenges(){
        return $this->HasMany('App\Challenge','barcode_id','id');
    }
}

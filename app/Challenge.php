<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    //
     protected $fillable = ['title','description','number','allow','product_id'];
    /**
     * Get all of the post's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }

    public function kids(){
        return $this->belongsToMany('App\User','challenge_solutions','challenge_id','kid_id')->withPivot('description','id');
    }

    public function getImageForWhoTakeChallengeAttribute(){
       // image_for_who_take_challenge
       $kids_id = $this->kids->pluck('id')->toArray();
       return Image::whereIn('imageable_id',$kids_id)->where('imageable_type','App\User')->limit(8)->get();
    }
}

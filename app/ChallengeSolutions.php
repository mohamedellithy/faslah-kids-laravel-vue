<?php

namespace App;
# use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;
class ChallengeSolutions extends Model
{
    //
    protected $table = 'challenge_solutions';
    protected $fillable = ['description','kid_id','challenge_id'];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function challenge(){
        return $this->belongsTo('App\Challenge','challenge_id','id');
    }

    public function kid(){
        return $this->belongsTo('App\User','kid_id','id');
    }
}

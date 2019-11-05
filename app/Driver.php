<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = "driver";
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function bus()
    {
        return $this->hasOne('App\Bus');
    }
}

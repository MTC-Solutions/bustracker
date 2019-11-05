<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $table = "bus";

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function trip()
    {
        return $this->hasOne('App\Trip');
    }
}

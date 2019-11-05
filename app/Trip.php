<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = "trip";

    public function bus()
    {
        return $this->belongsTo('App\Bus');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profile";
    public function driver()
    {
        return $this->hasOne('App\Driver');
    }
}

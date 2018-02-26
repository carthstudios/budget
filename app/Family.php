<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function members()
    {
        return $this->hasMany('App\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function family()
    {
        return $this->belongsTo('App\Family');
    }
}

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

    public function getDates()
    {
        /* substitute your list of fields you want to be auto-converted to timestamps here: */
        return array('created_at', 'updated_at', 'date');
    }
}

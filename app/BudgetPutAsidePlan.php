<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetPutAsidePlan extends Model
{
    const PUTSIDE_CATEGORY_ID = 11;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetPutAsidePlan extends Model
{
    const TYPE_YEARLY   = 1;
    const TYPE_MONTHLY  = 2;

    const PUTSIDE_CATEGORY_ID = 11;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}

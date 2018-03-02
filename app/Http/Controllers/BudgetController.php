<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request, int $month = 0, int $year = 0)
    {
        return view('budget', [
                                        'month' => $month == 0 ? Carbon::now()->month : $month,
                                        'year'  => $year == 0  ? Carbon::now()->year  : $year
                                    ]);
    }
}

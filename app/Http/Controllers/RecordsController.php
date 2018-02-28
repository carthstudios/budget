<?php

namespace App\Http\Controllers;

use App\Category;
use App\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Swap\Laravel\Facades\Swap;

class RecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        // Only users with a family can create records
        if (Auth::user()->family_id == null)
        {
            return redirect()
                ->back()
                ->withErrors(["You are not part of a family, so you can't create records!"])
                ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'amount'    => 'required|numeric|min:0',
            'category'  => 'required|numeric',
            'comment'   => 'required',
            'currency'  => 'required'
        ]);

        if ($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $currency   = $request->input('currency');
        $comment    = $request->input('comment');
        $amount     = intval(floatval($request->input('amount'))*100);

        if (in_array($currency, ['EUR', 'USD', 'SGD']))
        {
            $category    = Category::find(intval($request->input('category')));
            $amount     *= Swap::latest("$currency/CHF")->getValue() * ($category->is_positive ? 0.97 : 1.03);
            $comment    .= " (from $currency)";
        }

        $new_record = new Record;
        $new_record->date           = Carbon::now();
        $new_record->user_id        = Auth::user()->id;
        $new_record->family_id      = Auth::user()->family_id;
        $new_record->amount         = $amount;
        $new_record->category_id    = intval($request->input('category'));
        $new_record->comment        = $comment;
        $new_record->save();

        return redirect()->back()->with('success', "New record created!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'    => 'required|numeric',
            'category'  => 'required|numeric',
            'comment'   => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $new_record = new Record;
        $new_record->date           = Carbon::now();
        $new_record->user_id        = Auth::user()->id;
        $new_record->amount         = intval($request->input('amount'))*100;
        $new_record->category_id    = intval($request->input('category'));
        $new_record->comment        = $request->input('comment');
        $new_record->save();

        return view('records.save_confirmation');
    }
}

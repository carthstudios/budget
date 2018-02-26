<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        return view('family');
    }
}

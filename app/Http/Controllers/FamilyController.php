<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{
    public function view_list(Request $request)
    {
        return view('family.viewlist');
    }

    public function add(Request $request)
    {
        $email      = $request->get('email');
        $family_id  = Auth::user()->family_id;

        $user = new User;
        $user->email = $email;
        $user->family_id = $family_id;
        $user->save();

        return redirect()->back();
    }

    public function save_name(Request $request)
    {
        $user_id    = $request->get('user_id');
        $name       = $request->get('name');

        $user = User::find($user_id);
        $user->name = $name;
        $user->save();

        return redirect()->back();
    }
}

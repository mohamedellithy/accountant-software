<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class SetAccount extends Controller
{
    //

    public function set_password(Request $request){
        return view(config('app.theme').'.auth.register');
    }


    public function save_password(Request $request){
        $request->validate([
            'password' => 'required'
        ]);

        User::where('email',$request->input('email'))->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect()->route('login');
    }
}

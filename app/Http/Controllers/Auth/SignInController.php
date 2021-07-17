<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function __construct(){
        $this->middleware(['guest'])->except('signout');
        $this->middleware(['auth'])->only('signout');
    }

    public function index(){
        return view('auth.signin');
    }

    public function signin(Request $request){
        $this->validate($request, [
            'email' => 'required_without:student_id',
            'password' => 'required',
        ]);
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if(!auth()->user())
            return back()->with('status', 'Account don\'t Exist');

        return (auth()->user()->user_type == 'admin')? view('su.dashboard') : view('student.dashboard');
    }

    public function signout(Request $request){
        Auth::logout(auth()->user());
        return view('auth.signin');
   }
}

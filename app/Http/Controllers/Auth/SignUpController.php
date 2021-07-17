<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function __construct(){
        $this->middleware(['guest']);
    }

    public function index(){
        return view('auth.signup');
    }

    public function signup(Request $request){
        $this->validate($request, [
            'name' => 'required|string|regex:/^[a-zA-Z\sÑñ]*$/',
            // 'email' => 'required|email|unique:users|ends_with:@cvsu.edu.ph',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ],);

        $newUser = User::create([
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($newUser));

        Auth::login($newUser) ;
        return redirect()->route('home');

    }

}
    

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('changeOwnPass', 'updateOwnPass');
        $this->middleware(['auth', 'verified'])->only(['changeOwnPass', 'updateOwnPass']);
    }

    public function requestReset(){
        return view('verify.forgot-password');
    }

    public function sendReset(Request $request){

        $this->validate($request, ['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return ($status === Password::RESET_LINK_SENT)? back()->with(['status'=> __($status)]): back()->withErrors(['email' => __($status)]);
    }

    public function newPass($token){
        return view('verify.new-pass',['token' => $token]);
    }

    public function changeOwnPass(){
        return view('auth.change-pass');
    }

    public function updateOwnPass(Request $request){
            $this->validate($request, [
                'password' => 'required|confirmed',
            ]);

            User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
            return back()->with('status', 'Password Update Success!');
    }

    public function updatePass(Request $request){
        
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();   
                event(new Password($user));
            }
        );
    
        return ($status === Password::PASSWORD_RESET) ? redirect()->route('auth.signin')->with('status', __($status)) : back()->withErrors(['email' => [__($status)]]);
    }
}

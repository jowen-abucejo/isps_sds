<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleSignInController extends Controller
{
    public function __construct(){
        $this->middleware(['guest']);
    }

    public function index(){
        return Socialite::driver('google')->with(['prompt' => 'select_account',])->redirect();
    }

    public function signin(Request $request){
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->getId())->orWhere('email', $user->getEmail())->first();

            if($findUser) {
                Auth::login($findUser);
                if($findUser->isAdmin())
                    return redirect()->route('su.dashboard');
                return redirect()->route('student.dashboard');
            } else {
                $email = $user->getEmail();
                //if(str_ends_with($email, '@cvsu.edu.ph')){
                    $newUser = User::create([
                        'google_id' => $user->getId(),
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'password' => Hash::make($user->getId()),
                    ]);
                    event(new Registered($newUser));
                    
                    Auth::login($newUser);
                    return redirect()->route('student.profile');
                //} 
                //return redirect()->route('auth.signup')->with('status', 'Email account not a CvSU account!');
            }
        } catch (Exception $exc) {
            return redirect()->route('auth.signup')->with('status', 'Login Failed!');
        }
    }
}

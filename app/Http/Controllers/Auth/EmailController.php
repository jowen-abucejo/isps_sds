<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('requestReset');
        $this->middleware('signed')->only('emailVerified');
        $this->middleware('throttle:6,1')->only('emailVerificationResend');
    }
    public function index(){
        $courses = DB::table('courses')->where('active', 'ACTIVE')->get();
        return view('verify.verify-email', ['courses'=> $courses]);        
    }

    public function emailVerified(EmailVerificationRequest $emailVerificationRequest){
        $emailVerificationRequest->fulfill();
        return redirect()->intended('student.dashboard');
    }

    public function emailVerificationResend(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification Link Sent!');
    }

}

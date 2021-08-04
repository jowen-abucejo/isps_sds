<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index(Request $request)
    {
        $users = User::orderBy('id', 'asc')->get();
        $read_user = $users->where('id',$request->user_id)->first();
        return view('su.users', ['users' => $users, 'read_user' => $read_user]);
    }

    public function update(Request $request)
    {
        $ignoreSelf = ($request->toUpdate)?? 0;
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                'string',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query
                        ->where('email', $request->email);
                })->ignore($ignoreSelf),
            ],
            'usertype' => 'required',
        ]);

        if($ignoreSelf === 0){
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'user_type' => $request->usertype,
                'password' => Hash::make($request->name),
            ]);

            return redirect()->route('su.users')->with('status', 'Account Registration Success!');
        }

        $success = User::where('id', $request->toUpdate)->update([
            'name' => $request->name,    
            'email' => $request->email,    
            'user_type' => $request->usertype,    
        ]);

        if($success)
            return redirect()->route('su.users')->with('status', 'Update Success!');
        else
            return back()->with('status', 'Update Failed!');
    }
}

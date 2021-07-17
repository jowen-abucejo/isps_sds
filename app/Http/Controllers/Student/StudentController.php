<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);   
    }

    public function index(Request $request){
        if($request->user()->user_type == 'admin'){
            return view('su.dashboard');        
        } else {
            return view('student.profile');
        }
    }

    public function profile(Request $request){

        $this->validate($request, [
            'student_id' => 'required|numeric|unique:students',
            'course' => 'required',
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'email' => ['required', 'email', endsWith('@cvsu.edu.ph'),],
            'contact_number' => 'required|numeric',
            'address' => 'required',
        ]);

        if($request->user()->student){
            
        }

        Student::create([
            'student_id' => $request->student_id,
            'course' => strtoupper($request->course),
            'first_name' => strtoupper($request->first_name),
            'middle_name' => strtoupper($request->middle_name),
            'last_name' => strtoupper($request->last_name),
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'email' => strtoupper($request->contact_number),
            'contact_number' => $request->contact_number,
            'address' => strtoupper($request->address),
        ]);
        
        return redirect()->route('student.dashboard');

    }
    
}

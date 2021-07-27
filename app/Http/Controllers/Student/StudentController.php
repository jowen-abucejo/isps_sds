<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'student']);   
    }

    public function index(){
        $courses = DB::table('courses')->where('active', 'ACTIVE')->orderBy('course_desc', 'asc')->get();
        return view('student.profile')->with('courses', $courses);        
    }

    public function profile(Request $request){
        $currentStudent = auth()->user()->student;
        if($currentStudent){
            $this->validate($request, [
                'student_id' => ['required', 'numeric', Rule::unique('students')->ignore('id', $currentStudent->id)],
                'course' => 'required',
                'first_name' => 'required|string',
                'middle_name' => 'required|string',
                'last_name' => 'required|string',
                'gender' => 'required',
                'birth_date' => 'required|date',
                'email' => ['required', 'email',],
                'mobile' => 'required|numeric',
                'address' => 'required',
            ]);
            $currentStudent->update([
                'student_id' => $request->student_id,
                'user_id' => auth()->user()->id,
                'course_id' => $request->course,
                'first_name' => strtoupper($request->first_name),
                'middle_name' => strtoupper($request->middle_name),
                'last_name' => strtoupper($request->last_name),
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => strtoupper($request->address),
            ]);
            $courses = DB::table('courses')->where('active', 'ACTIVE')->get();
            return back()->with([
                'status' => 'Profile Update Success!',
                'courses' => $courses,
            ]);
        } else {
            $this->validate($request, [
                'student_id' => 'required|numeric|unique:students',
                'course' => 'required',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'gender' => 'required',
                'birth_date' => 'required|date',
                'email' => ['required', 'email',],
                'mobile' => 'required|numeric',
                'address' => 'required',
            ]);
            Student::create([
                'student_id' => $request->student_id,
                'user_id' => auth()->user()->id,
                'course_id' => strtoupper($request->course),
                'first_name' => strtoupper($request->first_name),
                'middle_name' => strtoupper($request->middle_name),
                'last_name' => strtoupper($request->last_name),
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => strtoupper($request->address),
            ]);
            $courses = DB::table('courses')->where('active', 'ACTIVE')->get();
            return redirect()->route('student.profile')->with([
                'status' => 'Student Profile Created!',
                'courses' => $courses,
            ]);
        }
        
    }
}

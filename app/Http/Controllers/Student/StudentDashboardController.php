<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentDashboardController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified', 'student']);
    }

    public function index(){
        return view('student.dashboard');
    }

    public function showScholarships(Request $request)
    {   
        $scholarships = Scholarship::where('active', 'ACTIVE')->orderBy('description', 'asc')->get();
        $read_sch = ScholarshipApplication::where('id', $request->scholarship_id)->where('student_id', $request->user()->student->id)->first();
        return view('student.scholarships', ['scholarships' => $scholarships, 'read_sch' => $read_sch]);
    }
    
}

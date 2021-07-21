<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if($request->user()->student)
            $scholarships = DB::table('scholarships')->where('active', 'ACTIVE')->get();
        return view('student.scholarships', ['scholarships' => $scholarships,]);
    }

    public function saveApplication(Request $request)
    {
        $selectedScholarship = DB::table('scholarships')->where('id', $request->scholarship)->where('active', 'ACTIVE')->get()->first();
        if(!$selectedScholarship->count()) return back()->with('status', 'No Scholarship Selected!');
        $this->validate($request, [
            'scholarship' => [
                'required', 
                Rule::unique('scholarship_applications')->where(function ($query) use ($request) {
                    return $query
                        ->where('student_id', $request->user()->student->student_id)
                        ->where('scholarship_id', $request->scholarship)
                        ->where('sy', $request->school_year)
                        ->where('sem', $request->semester);
                }),
            ],
            'year_level' => 'required',
            'school_year' => 'required',
            'semester' => 'required',
            'gpa' => [
                'required',
                'between:'.$selectedScholarship->max_gpa.','.$selectedScholarship->min_gpa
            ],
            'lowest_grade' => [
                'required',
                'max:'.$selectedScholarship->lowest_grade,
            ],
        ], [
            'scholarship.unique' => 'You have same ongoing scholarship application!',
            'gpa.between' => 'Selected Scholarship require GPA between '.$selectedScholarship->gap_max.' and'.$selectedScholarship->gpa_min.'.',
        ]);

        ScholarshipApplication::create([
            'scholarship_id' => $request->scholarship,
            'student_id' => $request->user()->student->id,
            'year_level' => $request->year_level,
            'sem' => $request->semester,
            'sy' => $request->school_year,
            'gpa' => $request->gpa,
            'lowest_grade' => $request->lowest_grade, 
        ]);
        return back()->with([ 'requirements' => $selectedScholarship->requirements, ]);
    }
}

<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollee;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }
    
    public function index(Request $request)
    {
        $check = ScholarshipApplication::count();
        $sy_list = ScholarshipApplication::groupBy('sy')->select('sy')->orderBy('sy', 'desc')->get();
        $filter = ['sy' => '', 'sem' => '', 'status' => 'OK'];
        $scholarships = Scholarship::where('active', 'ACTIVE')->get();
        $grantees = 0;
        $enrollees = 0;
        if($check){
            if($request->sy && $request->sem){
                $filter['sy'] = $request->sy;
                $filter['sem'] = $request->sem;
            } else {
                $get_latest_period = ScholarshipApplication::select('sy', 'sem')->where('sy', ScholarshipApplication::max('sy'))->first();
                $filter['sy'] = $get_latest_period->sy;
                $filter['sem'] = $get_latest_period->sem;
            }
            $grantees = ScholarshipApplication::where('sy', $filter['sy'])->where('sem', $filter['sem'])->where('status', $filter['status'])->get();
            $enrollees = Enrollee::groupBy('course_id')->selectRaw('course_id, SUM(num_of_enrollee) as enrollees_count' )->where('sy', $filter['sy'])->where('sem', $filter['sem'])->get();
            $courses = ($enrollees)? Course::whereIn('id', $enrollees->pluck('course_id'))->get() : Course::where('active', 'ACTIVE')->get();            ;
            return view('su.dashboard', ['courses' => $courses, 'scholarships' => $scholarships, 'filter' => $filter, 'grantees' =>$grantees, 'sy_list' => $sy_list, 'enrollees' => $enrollees ]);
        }
        $courses = Course::where('active', 'ACTIVE')->get();
        return view('su.dashboard', ['courses' => $courses, 'scholarships' => $scholarships, 'filter' => $filter, 'grantees' =>$grantees, 'sy_list' => $sy_list, 'enrollees' => $enrollees, 'no_records' => 'No Scholarship Applications Found']);
    }
}

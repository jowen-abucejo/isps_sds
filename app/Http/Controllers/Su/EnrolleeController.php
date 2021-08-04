<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollee;
use Illuminate\Http\Request;

class EnrolleeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index(Request $request){
        $courses = Course::where('active', 'ACTIVE')->get();
        $enrollees = 0;
        $enrollees_records = Enrollee::groupBy('sy')->select('sy')->orderBy('sy', 'desc')->get();
        return view('su.enrollees', ['courses' => $courses, 'enrollees' => $enrollees, 'enrollees_records' => $enrollees_records]);
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'update_sy' => 'required',
            'update_sem' => 'required',
        ],[
            'update_sy.required' => 'No School Year Selected.',
            'update_sem.required' => 'No Semester Selected.',
        ]);

        $period_cover = ['sem' => $request->update_sem, 'sy' => $request->update_sy];
        $enrollees = Enrollee::where('sy', $period_cover['sy'])->where('sem', $period_cover['sem'])->get();
        if(!$enrollees->count()) return redirect()->route('su.enrollees')->with('status', 'No Records for SY '.$request->update_sy.' Semester '.$request->update_sem);
        $enrollees_records = Enrollee::groupBy('sy')->select('sy')->orderBy('sy', 'desc')->get();
        $courses = Course::whereIn('id', $enrollees->pluck('course_id'))->get();
        return view('su.enrollees', ['courses' => $courses, 'enrollees' => $enrollees, 'enrollees_records' => $enrollees_records, 'period_cover' => $period_cover]);
    }

    public function save(Request $request)
    {
        $to_update =($request->toUpdate)?? '0';
        $courses ='';
        $message ='Record Save!';
        $count = Enrollee::where('sy', $request->sy)->where('sem', $request->sem)->count();
        if($to_update){
            if(($request->sy != $request->toUpdateSy || $request->sem != $request->toUpdateSem) && $count > 0){
                return back()->with('status', 'Record already exists for SY'.$request->sy.' Semester '.$request->sem);
            }
            $courses = Enrollee::groupBy('course_id')->select('course_id')->where('sy', $request->toUpdateSy)->where('sem', $request->toUpdateSem)->get();
            $message = 'Record Update Success!';
        } else {
            if($count > 0){
                return back()->with('status', 'Record already exists for SY'.$request->sy.' Semester '.$request->sem); 
            }
            $courses = Course::select('id')->where('active', 'ACTIVE')->get();
        }
        $this->validate($request, [
            'sy' => [
                'required',
                'max:9',
                function($attribute, $value, $fail){
                    $years = explode('-', $value);
                    if((count($years) != 2) || ($years[1]-$years[0] != 1) || $years[1] > date('Y'))
                        return $fail('Invalid school year.');
                }
            ],
            'sem' => 'required',
        ],[
            'sy.required' => 'School year field is required.',
            'sem.required' => 'Semester field is required.'
        ]);
        foreach ($courses as $course) {
            $cid = (!$to_update)? $course->id : $course->course_id;
            for ($i=1; $i < 5; $i++) { 
                Enrollee::updateOrCreate(
                    [
                        'course_id' => $cid,
                        'sy' => $request->sy,
                        'sem' => $request->sem,
                        'year_level' => $i,
                    ],
                    [
                        'num_of_enrollee' => $request->input('y'.$i.$cid),
                    ]
                );
            }
        }
        return redirect()->route('su.enrollees')->with('status', $message);
    }
}

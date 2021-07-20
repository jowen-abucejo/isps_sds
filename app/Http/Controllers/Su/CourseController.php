<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index(Request $request){
        $courses = DB::table('courses')->get();
        $read_course = $courses->where('id',$request->course_id)->first();
        return view('su.courses', ['courses' => $courses, 'read_course' => $read_course]);
    }

    public function save(Request $request){
        if(!$request->toUpdate)  {  
            $this->validate($request, [
                'course_code' => [
                    'required',
                    'string',
                    Rule::unique('courses')->where(function ($query) use ($request) {
                        return $query
                            ->where('course_code', strtoupper($request->course_code))
                            ->where('major', strtoupper($request->major));
                    }),
                ],
                'course_desc' => 'required|string',
            ]);

            Course::create([
                'course_code' => strtoupper($request->course_code),
                'course_desc' => strtoupper($request->course_desc),
                'major' => strtoupper($request->major),
            ]);

            return redirect()->route('su.courses')->with('status', 'Course Registration Success!');
        }    

        $this->validate($request, [
            'course_code' => [
                'required',
                'string',
                Rule::unique('courses')->where(function ($query) use ($request) {
                    return $query
                        ->where('course_code', strtoupper($request->course_code))
                        ->where('major', strtoupper($request->major));
                })->ignore($request->toUpdate),
            ],
            'course_desc' => 'required|string',
        ]);
        $success = DB::table('courses')->where('id', $request->toUpdate)->update([
            'course_code' => strtoupper($request->course_code),    
            'course_desc' => strtoupper($request->course_desc),    
            'major' => strtoupper($request->major),    
        ]);

        if($success)
            return redirect()->route('su.courses')->with('status', 'Update Success!');
        else
            return back()->with('status', 'Update Failed!');
    }

    public function changeStatus(Request $request){
        $newStatus = ($request->active == 'ACTIVE')? 'INACTIVE' : 'ACTIVE';
        if(DB::table('courses')->where('id', $request->course_id)->update(['active' => $newStatus]))
            return back();
        return back()->with('status', 'Status Update Failed!');
    }
}

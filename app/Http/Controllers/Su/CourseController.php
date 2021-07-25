<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index(Request $request){
        $courses = Course::get();
        $read_course = $courses->where('id',$request->course_id)->first();
        return view('su.courses', ['courses' => $courses, 'read_course' => $read_course]);
    }

    public function save(Request $request){
        $ignoreSelf = ($request->toUpdate)?? 0;
        $this->validate($request, [
            'course_code' => [
                'required',
                'string',
                Rule::unique('courses')->where(function ($query) use ($request) {
                    return $query
                        ->where('course_code', $request->course_code)
                        ->where('major', strtoupper($request->major));
                })->ignore($ignoreSelf),
            ],
            'course_desc' => 'required|string',
        ], [
            'course_code.unique' => 'Course already registered.',
            'course_desc.required' => 'The course description field is required',
        ]);

        if($ignoreSelf === 0){
            Course::create([
                'course_code' => $request->course_code,
                'course_desc' => strtoupper($request->course_desc),
                'major' => strtoupper($request->major),
            ]);

            return redirect()->route('su.courses')->with('status', 'Course Registration Success!');
        }

        $success = Course::where('id', $request->toUpdate)->update([
            'course_code' => $request->course_code,    
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
        if(Course::where('id', $request->course_id)->update(['active' => $newStatus]))
            return back();
        return back()->with('status', 'Status Update Failed!');
    }
}

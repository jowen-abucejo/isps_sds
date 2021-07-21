<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ScholarshipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index(Request $request)
    {
        $scholarships = DB::table('scholarships')->get();
        $read_sch = $scholarships->where('id', $request->scholarship_id)->first();
        return view('su.scholarships', ['scholarships' => $scholarships, 'read_sch' => $read_sch]);
    }

    public function save(Request $request){
        $ignoreSelf = ($request->toUpdate)?? 0;
        $this->validate($request, [
            'scholarship_code' => [
                'required',
                'string',
                Rule::unique('scholarships')->where(function ($query) use ($request) {
                    return $query
                        ->where('scholarship_code', strtoupper($request->scholarship_code))
                        ->where('type', strtoupper($request->type));
                })->ignore($ignoreSelf),
            ],
            'description' => 'required|string',
            'gpa_max' => 'lt:gpa_min',
            'gpa_min' => 'gt:gpa_max',
        ], [
            'scholarship_code.unique' => 'Scholarship already exists.',
            'gpa_max.lt' => 'Maximum GPA must be higher than Minimum GPA.',
            'gpa_min.gt' => 'Minimum GPA must be lower than Maximum GPA.',
        ]); 
        
        if($ignoreSelf === 0){
            Scholarship::create([
                'scholarship_code' => strtoupper($request->scholarship_code),
                'description' => strtoupper($request->description),
                'type' => strtoupper($request->type),
                'gpa_max' => $request->gpa_max,
                'gpa_min' => $request->gpa_min,
                'lowest_grade' => $request->lowest_grade,
            ]);

            return redirect()->route('su.scholarships')->with('status', 'Scholarship Registration Success!');
        }

        $success = DB::table('scholarships')->where('id', $request->toUpdate)->update([
            'scholarship_code' => strtoupper($request->scholarship_code),    
            'description' => strtoupper($request->description),    
            'type' => strtoupper($request->type),  
            'gpa_max' => $request->gpa_max,
            'gpa_min' => $request->gpa_min,
            'lowest_grade' => $request->lowest_grade,
        ]);

        if($success)
            return redirect()->route('su.scholarships')->with('status', 'Update Success!');
        else
            return back()->with('status', 'Update Failed!');
    }
}

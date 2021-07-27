<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScholarshipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index(Request $request)
    {
        $scholarships = Scholarship::orderBy('description', 'asc')->get();
        $read_sch = $scholarships->where('id', $request->scholarship_id)->first();
        return view('su.scholarships', ['scholarships' => $scholarships, 'read_sch' => $read_sch]);
    }

    public function save(Request $request){
        $ignoreSelf = ($request->toUpdate)?? 0;
        if(!$request->gpa_max) $request->gpa_max = 1;
        if(!$request->gpa_min) $request->gpa_min = 5;
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
            'gpa_max' => 'lte:gpa_min',
            'gpa_min' => 'gte:gpa_max',
        ], [
            'scholarship_code.unique' => 'Scholarship already exists.',
            'gpa_max.lte' => 'Maximum GPA must be higher than Minimum GPA.',
            'gpa_min.gte' => 'Minimum GPA must be lower than Maximum GPA.',
        ]); 
        
        if($ignoreSelf === 0){
            $newSc = Scholarship::create([
                'scholarship_code' => strtoupper($request->scholarship_code),
                'description' => strtoupper($request->description),
                'type' => strtoupper($request->type),
            ]);

            // $newQ =Qualification::create([
            //     'gpa_max' => $request->gpa_max,
            //     'gpa_min' => $request->gpa_min,
            //     'lowest_grade' => $request->lowest_grade,
            //     'minimum_units' => $request->minimum_units,
            //     'allow_inc' => $request->allow_inc,
            //     'allow_drop' => $request->allow_drop,
            // ]);
            $newSc->qualification()->create([
                'gpa_max' => $request->gpa_max,
                'gpa_min' => $request->gpa_min,
                'lowest_grade' => $request->lowest_grade,
                'minimum_units' => $request->minimum_units,
                'allow_inc' => ($request->allow_inc)? 1 : 0,
                'allow_drop' => ($request->allow_drop)? 1 : 0,
            ]);

            return redirect()->route('su.scholarships')->with('status', 'Scholarship Registration Success!');
        }

        $success = tap(Scholarship::where('id', $request->toUpdate))->update([
            'scholarship_code' => strtoupper($request->scholarship_code),    
            'description' => strtoupper($request->description),    
            'type' => strtoupper($request->type),  
        ])->first();

        if($success){
            $success->qualification->update([
                
            'gpa_max' => $request->gpa_max,
            'gpa_min' => $request->gpa_min,
            'lowest_grade' => $request->lowest_grade,
            'minimum_units' => $request->minimum_units,
            'allow_inc' => ($request->allow_inc)? 1 : 0,
            'allow_drop' => ($request->allow_drop)? 1 : 0,
            ]);
            return redirect()->route('su.scholarships')->with('status', 'Update Success!');
        }
            
        else
            return back()->with('status', 'Update Failed!');
    }

    public function changeStatus(Request $request)
    {
        $newStatus = ($request->active == 'ACTIVE')? 'INACTIVE' : 'ACTIVE';
        $success = Scholarship::where('id', $request->scholarship_id)->update([
            'active' => $newStatus,
        ]);

        return ($success)? back() : back()->with('status', 'Status Update Failed!');
    }
}

<?php

namespace App\Http\Controllers\Su;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RequirementController extends Controller
{
    
    public function index(Request $request)
    {   
        $requirements = Requirement::get();
        $read_req = $requirements->where('id', $request->requirement_id)->first();
        $scholarships = Scholarship::where('active', 'ACTIVE')->get();
        return view('su.requirements',['requirements' => $requirements, 'read_req' => $read_req, 'scholarships' => $scholarships]);
    }

    public function save(Request $request)
    {
        $ignoreSelf = ($request->toUpdate)?? 0;
        $this->validate($request, [
            'document_name' => [
                'required',
                Rule::unique('requirements')->where(function($query) use ($request){
                    return $query
                        ->where('document_name', strtoupper($request->document_name));
                })->ignore($ignoreSelf),
            ]
        ]);

        if($ignoreSelf === 0){
            $new_requirement = Requirement::create([
                'document_name' => strtoupper($request->document_name),
            ]);
            
            $new_requirement->scholarships()->attach($request->required_for);
            return redirect()->route('su.requirements')->with('status', 'Requirement Registration Success!');
        }

        $to_update = tap(Requirement::where('id', $request->toUpdate))->update([
            'document_name' => strtoupper($request->document_name),
        ])->first();

        if(!$to_update)
            return back()->with('status', 'Update Failed!');
    
        $to_update->scholarships()->sync($request->required_for);
        return redirect()->route('su.requirements')->with([
            'status' => 'Update Success!',
        ]);
    
    }

    public function changeStatus(Request $request)
    {
        $newStatus = ($request->status == 'ACTIVE')? 'INACTIVE' : 'ACTIVE';
        $success = Requirement::where('id', $request->req_id)->update([
            'status' => $newStatus,
        ]);

        return ($success)? back() : back()->with('status', 'Status Update Failed!');
    }
}

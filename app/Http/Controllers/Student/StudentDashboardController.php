<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $scholarships = Scholarship::where('active', 'ACTIVE')->get();
        $read_sch = ScholarshipApplication::where('id', $request->scholarship_id)->where('student_id', $request->user()->student->id)->first();
        return view('student.scholarships', ['scholarships' => $scholarships, 'read_sch' => $read_sch]);
    }

    public function saveApplication(Request $request)
    {
        $ignoreSelf =($request->toUpdate)?? 0;
        $selectedScholarship = Scholarship::where('id', $request->scholarship_id)->first();
        $request->has_inc = ($request->has_inc)? 1 : 0;
        $request->has_drop = ($request->has_drop)? 1 : 0;
        if(!$selectedScholarship) return back()->with('status', 'No Scholarship Selected!');
        $this->validate($request, [
            'scholarship_id' => [
                'required', 
                Rule::unique('scholarship_applications')->where(function ($query) use ($request) {
                    return $query
                        ->where('scholarship_id', $request->scholarship_id)
                        ->where('student_id', $request->user()->student->id)
                        ->where('sy', $request->school_year)
                        ->where('sem', $request->semester);
                })->ignore($ignoreSelf),
            ],
            'year_level' => 'required',
            'school_year' => 'required',
            'semester' => 'required',
            'gpa' => [
                'required',
                'gte:'.$selectedScholarship->qualification->gpa_max,
                'lte:'.$selectedScholarship->qualification->gpa_min,
            ],
            'lowest_grade' => [
                'required',
                'lte:'.$selectedScholarship->qualification->lowest_grade,
            ],
            'num_of_units' => [
                'required',
                'gte:'.$selectedScholarship->qualification->minimum_units,
            ],
            'has_inc' => 'lte:'.$selectedScholarship->qualification->allow_inc,
            'has_drop' => 'lte:'.$selectedScholarship->qualification->allow_drop,
        ], [
            'scholarship_id.unique' => 'Same scholarship application exist!',
            'gpa.gte' => 'Selected Scholarship require GPA between '.$selectedScholarship->qualification->gpa_max.' and '.$selectedScholarship->qualification->gpa_min.'.',
            'gpa.lte' => 'Selected Scholarship require GPA between '.$selectedScholarship->qualification->gpa_max.' and '.$selectedScholarship->qualification->gpa_min.'.',
            'has_inc.lte' => 'This scholarship require no INC grade',
            'has_drop.lte' => 'This scholarship require no DROP grade',  
            'num_of_units.required' => 'The number of units field is required',          
        ]);

        if($ignoreSelf === 0){
            $newSc = auth()->user()->student->scholarships()->create([
                'scholarship_id' => $request->scholarship_id,
                'student_id' => $request->user()->student->student_id,
                'year_level' => $request->year_level,
                'sem' => $request->semester,
                'sy' => $request->school_year,
                'gpa' => $request->gpa,
                'lowest_grade' => $request->lowest_grade, 
                'num_of_units' => $request->num_of_units,
                'has_inc' => $request->has_inc,
                'has_drop' => $request->has_drop,
            ]);
            foreach ($selectedScholarship->requirements as $requirement) {
                $newSc->submitted_documents()->create([
                    'requirement_id' => $requirement->id,
                    'status' => 'TO UPLOAD',
                ]);
            }
            return redirect()->route('student.requirements', ['sch_id' => $newSc->id]);
        }

        $updateSc = auth()->user()->student->scholarships()->where('id', $ignoreSelf)->first()->update([
            'scholarship_id' => $request->scholarship_id,
            'year_level' => $request->year_level,
            'sem' => $request->semester,
            'sy' => $request->school_year,
            'gpa' => $request->gpa,
            'lowest_grade' => $request->lowest_grade, 
            'num_of_units' => $request->num_of_units,
            'has_inc' => $request->has_inc,
            'has_drop' => $request->has_drop,
        ]);
        return back();
        return redirect()->route('student.requirements', ['sch_id' => $updateSc->id]);
    }

    public function requestRequirements(Request $request)
    {
        //check if student own the scholarship application
        if($sch_app = auth()->user()->student->scholarships->where('id', $request->sch_id)->first()){
            //check if there are requirements need to be upload 
            $reqs = $sch_app->submitted_documents->where('status', 'TO UPLOAD')->count();
            if(!$reqs){
                if($sch_app->status === 'REQUIREMENTS FOR UPLOAD') $sch_app->status = 'PENDING';
            }
            $requirements = $sch_app->submitted_documents;
            return view('student.requirements',['sch_id' => $request->sch_id, 'requirements' => $requirements]);
        
        }
        return redirect()->route('student.scholarships');
    }

    public function uploadRequirements(Request $request)
    {   
        //check if student own the scholarship application
        $sch_app = auth()->user()->student->scholarships->where('id', $request->sch_id)->first();
        if(!$sch_app) return back();//redirect back if not

        //check if there are requirements need to be upload
        $reqs = $sch_app->submitted_documents->where('status', 'TO UPLOAD')->all();
        if(!$reqs){
            if($sch_app->status === 'REQUIREMENTS FOR UPLOAD') $sch_app->status = 'PENDING';
            return redirect()->route('student.scholarships');
        }
        $path = 'requirements/'.$request->sch_id;
        $countInvalid = 0;
        $countValid = 0;
        
        foreach ($reqs as $doc) {
            if($request->hasFile('rq'.$doc->requirement_id)){
                $uploadFile =$request->file('rq'.$doc->requirement_id);
                if(!in_array($uploadFile->extension(), ['jpg', 'jpeg', 'pdf'])){
                    $countInvalid++;
                } else {
                    $storepath = Storage::putFile( $path, $uploadFile);
                    $doc->filename = $storepath;
                    $doc->status = 'UPLOADED';
                    $doc->save();
                    $countValid++;
                }
            }
        }

        //check if all requirements are already uploaded and update the status of scholarship application
        if($sch_app->submitted_documents->where('status', 'TO UPLOAD')->count() === 0){
            $sch_app->status = 'PENDING';
        }
        if($countValid === 0 && $countInvalid === 0)
            return back()->with('status', 'No files were uploaded!');

        $message = "";
        if($countInvalid > 0)
            $message = $countInvalid.' file/s are invalid type! ';
        if($countValid > 0 && $countInvalid > 0){
            $message.= 'Upload Success!';
            return back()->with('status', $message);
        }
        if($countInvalid === 0 && $countValid > 0){
            return redirect()->route('student.scholarships')->with('status', 'Upload Success!');
        }
    }

}

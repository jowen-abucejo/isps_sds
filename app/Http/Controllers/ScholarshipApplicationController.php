<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\SubmittedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ScholarshipApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('student')->only(['requestRequirements', 'uploadRequirements', 'saveApplication']);
        $this->middleware('admin')->except(['requestRequirements', 'uploadRequirements', 'saveApplication']);
    }

    public function index(Request $request)
    {
        $scholarship_code = strtoupper(str_replace('_', ' ', $request->scholarship_code));
        $scholarships = Scholarship::select('id')->where('scholarship_code', $scholarship_code)->get();
        $applications = ScholarshipApplication::wherein('scholarship_id', $scholarships)->where('status', '=', 'PENDING')->orderBy('created_at', 'asc')->get();
        return view('su.applications', [
            'applications' => $applications, 
            'scholarship_code' => $scholarship_code, 
            'application_id' => $request->application_id,
            
        ]);
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
            'school_year' => [
                'required',
                'max:9',
                function($attribute, $value, $fail){
                    $years = explode('-', $value);
                    if((count($years) != 2) || ($years[1]-$years[0] != 1) || $years[1] > date('Y'))
                        return $fail('Invalid school year.');
                }
            ],
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
                'course_id' => $request->user()->student->course_id,
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
                if($requirement->status === 'ACTIVE'){
                    $newSc->submitted_documents()->create([
                        'requirement_id' => $requirement->id,
                        'status' => 'TO UPLOAD',
                    ]);
                }
            }
            return redirect()->route('student.requirements', ['sch_id' => $newSc->id]);
        }

        $updateSc = auth()->user()->student->scholarships()->where('id', $ignoreSelf)->first();
        $updateSc->update([
            'scholarship_id' => $request->scholarship_id,
            'course_id' => $request->user()->student->course_id,
            'year_level' => $request->year_level,
            'sem' => $request->semester,
            'sy' => $request->school_year,
            'gpa' => $request->gpa,
            'lowest_grade' => $request->lowest_grade, 
            'num_of_units' => $request->num_of_units,
            'has_inc' => $request->has_inc,
            'has_drop' => $request->has_drop,
        ]);
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
            if($sch_app->status === 'REQUIREMENTS FOR UPLOAD') 
                ScholarshipApplication::where('id', $request->sch_id)->first()->update([
                    'status' => 'PENDING',
                ]);
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
            ScholarshipApplication::where('id', $request->sch_id)->first()->update([
                'status' => 'PENDING',
            ]);
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

    public function manageApplication(Request $request)
    {
        $to_update = ScholarshipApplication::where('id', $request->app_id)->first();
        foreach($to_update->submitted_documents as $doc){
            $doc->update([
                'status' => $request->input('status'.$doc->id),
                'comments' => $request->input('comment'.$doc->id),
            ]);
        }
        $count_to_upload = SubmittedDocument::where('scholarship_application_id', $request->app_id)->where('status', '!=', 'OK')->count();
        if($count_to_upload === 0){
            $to_update->update(['status' => 'OK',]);
        } else {
            $to_update->update(['status' => 'REQUIREMENTS FOR UPLOAD',]);
        }
        return back()->with('status', 'Application #'.$request->app_id.' Status Update Success');    

    }
    
    public function preview(Request $request)
    {
        $to_preview = SubmittedDocument::where('scholarship_application_id', $request->application_id)->where('requirement_id', $request->document_id)->first();
        if(!$to_preview)
            return back();
        return response()->file(storage_path('app/'.$to_preview->filename));
    }
}

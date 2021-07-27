@extends('layouts.mainview')

@section('active_view')
{{-- <div class="row mx-auto mb-5 rounded shadow bg-white py-5 col-12 col-md-10"> --}}
    @if ($review = $applications->where('id', $application_id)->first())
        <div class="col text-center"><h4>APPLICATION #{{ $application_id }}</h4></div>
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif
        <table class="text-left w-100 small table-bordered">
            <tr>
                <td>Student ID : </td><td>{{ $review->student->student_id }}</td>
            </tr>
            <tr>
                <td>Course : </td><td>{{ $review->student->course->course_desc }}</td>
            </tr>
            <tr>
                <td>Fullname : </td><td>{{ $review->student->first_name.' '.$review->student->middle_name.' '.$review->student->last_name }}</td>
            </tr>
            <tr>
                <td>SY : </td><td>{{ $review->sy }}</td>
            </tr>
            <tr>
                <td>Semester : </td><td>{{ $review->sem }}</td>
            </tr>
            <tr>
                <td>Scholarship : </td><td>{{ $review->scholarship->scholarship_code.' '.$review->scholarship->type }}</td>
            </tr>
            <tr>
                <td>GPA : </td><td>{{ $review->gpa }}</td>
            </tr>
            <tr>
                <td>Lowest Grade : </td><td>{{ $review->lowest_grade }}</td>
            </tr>
            <tr>
                <td>Number of Units : </td><td>{{ $review->num_of_units }}</td>
            </tr>
            <tr>
                <td>With INC : </td><td>{{ ($review->has_inc)? 'YES' : 'NO' }}</td>
            </tr>
            <tr>
                <td>With DROP : </td><td>{{ ($review->has_drop)? 'YES' : 'NO' }}</td>
            </tr>
        </table>
    <form method="POST" action="{{ route('su.manage.approved') }}" class="p-0 m-0 w-100">
        @csrf
        <input type="hidden" value="{{ $review->id }}" name="app_id">
        <table class="text-left w-100 small table-bordered">
            <tr><th colspan="2" class="text-center">*REVIEW REQUIREMENTS*</th></tr>
            @foreach ($review->submitted_documents as $sub_document )
            <tr>
                <td>
                    <a href="{{ route('su.requirement.preview',[
                        'document_id' => $sub_document->requirement_id, 
                        'application_id' => $sub_document->scholarship_application_id]) 
                        }}" target="_blank" >{{ $sub_document->requirement->document_name }}
                    </a>
                </td>
                <td class="py-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status{{ $sub_document->id }}" id="statusA{{ $sub_document->id }}" value="OK" checked>
                        <label class="form-check-label" for="statusA{{ $sub_document->id }}">Accept</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status{{ $sub_document->id }}" id="statusB{{ $sub_document->id }}" value="RE-UPLOAD">
                        <label class="form-check-label" for="statusB{{ $sub_document->id }}">Ask to Re-upload</label>
                    </div>
                    <div class="mt-2">
                        <textarea class="form-control-sm form-control"name="comment{{ $sub_document->id }}" placeholder="Comments(Optional)"></textarea>
                    </div>
                </td>
            </tr>
            @endforeach 
        </table>  
        <button class="btn btn-sm btn-info btn-block mt-3" type="submit">Save</button>
    </form>
    <a class="btn btn-danger btn-sm btn-block mt-3" href="{{ route('su.manage', ['scholarship_code' => Str::lower(Str::replace(' ', '_', $scholarship_code))]) }}">Close</a>
             
    @else
        <h4>MANAGE {{ $scholarship_code }} APPLICANTS</h4>
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif
    @endif
{{-- </div> --}}
@endsection
@section('bottom_view')
<table class="table table-bordered table-hover text-center table-sm table-striped table-light">
    <thead>
        <tr>
            <th>#</th> 
            <th>Scholarship</th> 
            <th>Student ID</th>
            <th>School Year</th> 
            <th>Semester</th> 
            <th>Status</th>
            <th>Action</th>             
        </tr>
    </thead>
    <tbody>
        @if($applications->count())
        @foreach ($applications as $application)
        <tr>
            <td>{{ $application->id }}</td> 
            <td>{{ $application->scholarship->scholarship_code }} {{ ($application->scholarship->type)?? '' }}</td> 
            <td>{{ $application->student->student_id }}</td>
            <td>{{ $application->sy }}</td> 
            <td>{{ $application->sem }}</td> 
            <td>{{ $application->status }}</td>
            <td>
                <a href="{{ route('su.manage', ['scholarship_code' => Str::lower(Str::replace(' ', '_', $scholarship_code)), 'application_id' => $application->id]) }}" class="btn btn-sm btn-info px-4">READ</a>
            </td>
        </tr>      
        @endforeach  
        @endif  
        <tr>
            <td colspan="7">
                @if (!$applications->count())
                  <p class="d-block alert-warning">No Scholarship Application Found</p>  
                @endif
            </td>
        </tr>        
    </tbody>
</table>
@endsection
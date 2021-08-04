@extends('layouts.mainview')

@section('active_view')
    @if($enrollees)
    <h4 class="mb-4">
        Your Editing Record of Enrollees
    </h4 >
    <p><b>FOR</b></p>
    <h4 class="mb-4">
        SY{{ $period_cover['sy'] }} {{ ($period_cover['sem'] == 1)? 'FIRST ' : 'SECOND ' }}SEMESTER
    </h4 >

    @if (session('status'))
        <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
    @endif

    <a href="{{ route('su.enrollees') }}" class="btn btn-block btn-info mt-5">Cancel Edit</a>
    @else
        <h4 class="mb-4">
            Create Record of Enrollees
        </h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif
        <p><b>OR</b></p>
        <form action="{{ route('su.enrollees') }}" method="POST">
            @csrf
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
                <select name="update_sy" class="form-control">
                    <option value="">** Select School Year **</option>
                    @foreach ($enrollees_records as $enr)
                        <option value="{{ $enr->sy }}">SY{{ $enr->sy }}</option>
                    @endforeach
                </select>
            </div>
            @error('update_sy')
             <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
                <select name="update_sem" class="form-control">
                    <option value="">** Select Semester **</option>
                    <option value="1" >First Semester</option>
                    <option value="2" >Second Semester</option>
                </select>
            </div>
            @error('update_sem')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            <button type="submit" class="btn btn-success btn-block mt-4">Edit Selected Record</button>
        </form> 
    @endif
@endsection

@section('bottom_view')
<form action="" method="POST">
    @csrf
    @method('patch')
@if ($enrollees)
<input type="hidden" name="toUpdate" value="1">
<input type="hidden" name="toUpdateSy" value="{{ $period_cover['sy'] }}">
<input type="hidden" name="toUpdateSem" value="{{ $period_cover['sem'] }}">
@endif
<div class="row bg-secondary p-2 mb-3">
    <div  class="col-md-4 offset-md-2 col-sm-6 col-12 col-12">
        <div class="input-group form-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-pen"></i></span>
            </div>
            <input type="text"  name="sy" id="sy" placeholder="School Year (e.g. 2020-2021)" class="form-control" @if($enrollees) value="{{ $period_cover['sy'] }}"@endif>
        </div>
        @error('sy')
            <p class="alert-danger text-left mb-0 px-3 rounded"><small> {{ $message }} </small></p>
        @enderror
    </div>
    
    <div class=" col-md-4 col-sm-6 col-12 col-12 pt-4 pt-sm-0">
        <div class="input-group form-group mb-1">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
            <select name="sem" id="sem" class="form-control">
                <option value="">** Select Semester **</option>
                <option value="1" @if($enrollees){{ ($period_cover['sem']==1)?' selected': '' }}@endif>First Semester</option>
                <option value="2" @if($enrollees){{ ($period_cover['sem']==2)?' selected': '' }}@endif>Second Semester</option>
            </select>
        </div>
        @error('sem')
            <p class="alert-danger text-left mb-0 px-3 rounded"><small> {{ $message }} </small></p>
        @enderror
    </div>
</div>
    <table class="table table-hover text-center table-sm table-striped table-light m-0" id="printable">
        <thead>
            <tr class="bg-dark text-light">
                <th style="vertical-align: middle; min-width: 100px;" colspan="2">Program/Course</th> 
                <th style="vertical-align: middle; min-width: 100px;">Major</th> 
                <th style="vertical-align: middle; min-width: 100px;">First Year</th> 
                <th style="vertical-align: middle; min-width: 100px;">Second Year</th> 
                <th style="vertical-align: middle; min-width: 100px;">Third Year</th>
                <th style="vertical-align: middle; min-width: 100px;">Fourth Year</th> 
                <th style="vertical-align: middle; min-width: 100px;">Total</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td colspan="2" class="text-left pl-3">{{ (Str::length($desc = str_replace(['Bachelor Of Science In ', ' In ', ' Of ' ], ['BS ', ' in ', ' of '], Str::title($course->course_desc))) <= 15 )? str_replace([' In ', ' Of ' ], [' in ', ' of '], Str::title($course->course_desc)) : $desc }}</td>
                <td>{{ ($course->major)? Str::title($course->major) : '' }}</td>
                <td><input type="number" step="1" min="0" name="y1{{ $course->id }}" class="col-12 yl1" value="@if($enrollees){{ $enrollees->where('course_id', $course->id)->where('year_level', 1)->first()->num_of_enrollee }}@else{{ (old('y1'.$course->id)?? '0') }}@endif"></td>
                <td><input type="number" step="1" min="0" name="y2{{ $course->id }}" class="col-12 yl2" value="@if($enrollees){{ $enrollees->where('course_id', $course->id)->where('year_level', 2)->first()->num_of_enrollee }}@else{{ (old('y2'.$course->id)?? '0') }}@endif"></td>
                <td><input type="number" step="1" min="0" name="y3{{ $course->id }}" class="col-12 yl3" value="@if($enrollees){{ $enrollees->where('course_id', $course->id)->where('year_level', 3)->first()->num_of_enrollee }}@else{{ (old('y3'.$course->id)?? '0') }}@endif"></td>
                <td><input type="number" step="1" min="0" name="y4{{ $course->id }}" class="col-12 yl4" value="@if($enrollees){{ $enrollees->where('course_id', $course->id)->where('year_level', 4)->first()->num_of_enrollee }}@else{{ (old('y4'.$course->id)?? '0') }}@endif"></td>
                <td><input type="text" readonly disabled id="ctotal{{ $course->id }}" class="col-12" value="0"></td>
            </tr>      
            @endforeach    
            <tr>
                <td colspan="2" class="border-top border-secondary"></td>
                <td class="text-right border-top border-secondary"><b>Total:</b></td>
                <td class="border-top border-secondary"><input type="number" readonly disabled id="y1total" class="col-12" value="0"></td>
                <td class="border-top border-secondary"><input type="number" readonly disabled id="y2total" class="col-12" value="0"></td>
                <td class="border-top border-secondary"><input type="number" readonly disabled id="y3total" class="col-12" value="0"></td>
                <td class="border-top border-secondary"><input type="number" readonly disabled id="y4total" class="col-12" value="0"></td>
                <td class="border-top border-secondary"><input type="text" readonly disabled id="total" class="col-12" value="0"></td>
            </tr>        
        </tbody>
        @if($courses->count())
        <tfoot>
            <tr>
                <td colspan="8" class="border-top border-dark py-3">@if($enrollees)<button class="btn btn-success w-25" type="submit">Update Record</button>@else <button class="btn btn-info w-25" type="submit">Save Record</button> @endif</td>    
            </tr>
        </tfoot>
        @endif
    </table>
</form>
@if (!$courses->count())
<p class="d-block alert-danger text-center py-2">No Active Program/Course</p>  
@endif
@endsection

@section('js_area')
<script>
    $('#printable tbody tr td input').on('input', function(){
        //alert('hello')
        var rtotal = 0;
        var ctotal=0;
        source = $(this);
        parentTR =  $(source).parents('tr');
        parentTR.find('td input[type="number"]').each(function() {
            rtotal += parseInt($(this).val());
        });
        parentTR.find('td input:text').last().val(rtotal);
        
        if(source.hasClass('yl1')){
            $('#printable tbody').find('tr td input.yl1').each(function() {
                ctotal += parseInt($(this).val());
            });
            $('#y1total').val(ctotal);
            $('#total').val(parseInt($('#y1total').val()) + parseInt($('#y2total').val()) + parseInt($('#y3total').val()) + parseInt($('#y4total').val()));
        } else if(source.hasClass('yl2')){
            $('#printable tbody').find('tr td input.yl2').each(function() {
                ctotal += parseInt($(this).val());
            });
            $('#y2total').val(ctotal);
            $('#total').val(parseInt($('#y1total').val()) + parseInt($('#y2total').val()) + parseInt($('#y3total').val()) + parseInt($('#y4total').val()));
        } else if(source.hasClass('yl3')){
            $('#printable tbody').find('tr td input.yl3').each(function() {
                ctotal += parseInt($(this).val());
            });
            $('#y3total').val(ctotal);
            $('#total').val(parseInt($('#y1total').val()) + parseInt($('#y2total').val()) + parseInt($('#y3total').val()) + parseInt($('#y4total').val()));
        } else if(source.hasClass('yl4')){
            $('#printable tbody').find('tr td input.yl4').each(function() {
                ctotal += parseInt($(this).val());
            });
            $('#y4total').val(ctotal);
            $('#total').val(parseInt($('#y1total').val()) + parseInt($('#y2total').val()) + parseInt($('#y3total').val()) + parseInt($('#y4total').val()));
        }
        
    });

    $('#printable tbody tr').each(function(){
        rtotal = 0;
        row = $(this);
        row.find('td input[type="number"]').each(function(){
            rtotal += parseInt($(this).val());
        });
        row.find('td input:text').last().val(rtotal);
    })
    ctotal=0;
    //first year column
    $('#printable tbody').find('tr td input.yl1').each(function() {
        ctotal += parseInt($(this).val());
    });
    $('#y1total').val(ctotal);

    ctotal=0;
    //second year column
    $('#printable tbody').find('tr td input.yl2').each(function() {
        ctotal += parseInt($(this).val());
    });
    $('#y2total').val(ctotal);

    ctotal=0;
    //third year column
    $('#printable tbody').find('tr td input.yl3').each(function() {
        ctotal += parseInt($(this).val());
    });
    $('#y3total').val(ctotal);

    ctotal=0;
    //fourth year column
    $('#printable tbody').find('tr td input.yl4').each(function() {
        ctotal += parseInt($(this).val());
    });
    $('#y4total').val(ctotal);
    $('#total').val(parseInt($('#y1total').val()) + parseInt($('#y2total').val()) + parseInt($('#y3total').val()) + parseInt($('#y4total').val()));

    $('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
    });
</script>
@endsection
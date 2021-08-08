@extends('layouts.mainview')

@section('active_view')
<div class="col text-center">
    <h4>Student Financial Assistance Grantees</h4>
    @if(false)
    <h6 class="alert-danger py-1">{{ $no_records }}</h6>
    @else
    <h6>{{ ($filter['sem'] == 1)? 'FIRST SEMESTER, SY ' : 'SECOND SEMESTER, SY ' }}{{ $filter['sy'] }}</h6>
    @endif
</div>
@if (session('status'))
    <p class="alert-danger rounded p-1"> {{ session('status') }} </p>   
@endif
@endsection

@php
    $cCount = $courses->count();
    $sCount = $scholarships->count();
    $column_width = round(100.0/($sCount+5), 2, PHP_ROUND_HALF_DOWN);
@endphp

@section('bottom_view')
<table class="table table-hover text-center table-sm table-striped table-light small">
    <tr class="bg-secondary text-light">
        <td colspan="{{ $sCount+5 }}">
            <form action="{{ route('su.dashboard') }}" method="GET">
            <div class="form-inline float-sm-left  border m-1 py-1 rounded">
                <div class="form-group mb-0 mx-2 my-1">  
                    <button class="btn btn-sm btn-primary p-0 px-3 border-light border" type="submit">Filter</button>
                </div>  
                <div class="form-group mb-0 mx-2 my-1">  
                    <select name="sem" id="sem" class="form-control-inline">
                        <option value="1">First Semester</option>
                        <option value="2" @if($filter['sem'] == 2) selected @endif>Second Semester</option>            
                    </select>
                </div>       
                <div class="form-group mb-0 mx-2 ">  
                    <select name="sy" id="sy" class="form-control-inline">
                        @foreach ($sy_list as $sy)
                            <option value="{{ $sy->sy }}" @if($filter['sy']==$sy->sy) selected @endif> SY {{ $sy->sy }} </option>
                        @endforeach           
                    </select>
                </div>  
            </div>
            </form>
                <div class="form-inline float-md-right float-left border my-1 mx-1 py-1 rounded shadow" id="exportbtns">     
                    <div class="form-group mb-0 mx-2">  
                        <span>Export or Copy</span>
                    </div>  
                </div>
        </td>
    </tr>
</table>
<table class="table table-hover text-center table-sm table-striped table-light shadow" id="printable">
    <thead>
        <tr class="bg-dark text-light">
            <th class="align-middle">PROGRAM/COURSE</th> 
            <th class="align-middle">MAJOR</th>
            <th class="align-middle">NO. OF ENROLLMENT @if($filter['sem'] == 1) 1st @else 2nd @endif SEM {{ $filter['sy'] }}</th>
            @foreach ($scholarships as $scholarship)
            <th class="align-middle">{{ ($scholarship->type)?:$scholarship->scholarship_code }} SCHOLARS</th>
            @endforeach 
            <th class="align-middle">Total % of Student Financial Assistance Grantees</th>
        </tr>
    </thead>
    <tbody>
        @if($cCount && $sCount)
            @php $watch_course = ''; @endphp
            @for ($i=0; $i < $cCount; $i++)
                @php $curr = $courses->get($i)->course_code; @endphp
                <tr>
                    @if($watch_course != $curr)
                        @php $watch_course = $curr; @endphp
                        <td class="text-left pl-3">
                            {{ (Str::length($desc = str_replace(['Bachelor Of Science In ', ' In ', ' Of ' ], ['BS ', ' in ', ' of '], Str::title($courses->get($i)->course_desc))) <= 15 )? str_replace([' In ', ' Of ' ], [' in ', ' of '], Str::title($courses->get($i)->course_desc)) : $desc }}
                        </td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ ($courses->get($i)->major)? Str::title($courses->get($i)->major) : '' }}</td>
                    <td>@if ($enrollees) {{ $enrollees->where('course_id', $courses->get($i)->id)->first()->enrollees_count }} @else 0 @endif</td>
                    @for ($j=0; $j < $sCount; $j++)
                        <td>
                            {{ ($a = $scholarships->get($j)->applications)? 
                                ($as = $a->where('course_id', $courses->get($i)->id)->where('sy', $filter['sy'])->where('sem', $filter['sem'])->where('status', $filter['status']))?
                                    $as->count(): 0 : 0 
                            }}
                        </td>
                    @endfor
                    {{-- <td class="border-left border-secondary border-top-0 border-bottom-0 border-right-0">
                        {{ $courses->get($i)->applications->where('sy', $filter['sy'])->where('sem', $filter['sem'])->where('status', $filter['status'])->count() }}
                    </td> --}}
                    @if ($i == (intval($cCount/2)))
                    <td class="border-secondary border-left border-right border-top-0 bg-white align-middle h4">
                        <b>@if($enrollees) {{ (round($grantees->count()*100/$enrollees->sum('enrollees_count'), 2))?: round($grantees->count()*100/$enrollees->sum('enrollees_count'), 4)  }}% @else 0% @endif</b>
                    </td>
                    @else
                    <td class="border-secondary border-left border-right border-top-0 bg-white">
                    </td>
                    @endif
                </tr>
            @endfor  
            <tr>
                <td class="text-right border-top border-secondary"> </td>
                <td class="text-right border-top border-secondary"><b>Total:</b></td>
                <td class="border-top border-secondary">@if($enrollees) {{ $enrollees->sum('enrollees_count') }} @else 0 @endif</td>
                @for ($j=0; $j<$sCount; $j++)
                    <td class="border-top border-secondary">
                        {{ $scholarships->get($j)->applications->where('sy', $filter['sy'])->where('sem', $filter['sem'])->where('status', $filter['status'])->count() }}
                    </td>
                @endfor
                {{-- <td class="border-top border-left border-secondary"><b>{{ $grantees }}</b></td> --}}
                <td class="border-secondary border-left border-right border-top-0 bg-white align-middle">
                </td>
            </tr>   
        @endif
    </tbody>
</table>

<table class="table table-hover text-center table-sm table-striped table-light small mt-5">
    <tr class="bg-secondary text-light">
        <td colspan="{{ $sCount+5 }}">
            <div class="form-inline float-sm-left p-2 border m-1 py-1 rounded" id="filterDiv"></div>
            <div class="form-inline float-md-right float-left border my-1 mx-1 py-1 rounded shadow" id="exportbtns2">     
                <div class="form-group mb-0 mx-2">  
                    <span>Export or Copy</span>
                </div>  
            </div>
        </td>
    </tr>
</table>
<table class="table table-hover text-center table-sm table-striped table-light shadow" id="printable2">
    <thead>
        <tr class="bg-dark text-light">
            <th class="align-middle">STUDENT ID</th> 
            <th class="align-middle">NAME</th>
            <th class="align-middle">COURSE/PROGRAM</th> 
            <th class="align-middle">SCHOLARSHIPS</th>
        </tr>
    </thead>
    <tbody>
        @if($grantees)
        @foreach ($grantees as $grantee)
        <tr>
            <td>{{ $grantee->student->student_id }}</td>
            <td>{{ $grantee->student->first_name }} {{ $grantee->student->middle_name }} {{ $grantee->student->last_name }}</td>
            <td>{{ $grantee->course->course_code }} {{ $grantee->year_level }}</td>
            <td>{{ $grantee->scholarship->scholarship_code }} {{ $grantee->scholarship->type }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@if (!$cCount && !$sCount)
        <p class="d-block alert-danger text-center py-2">No Records Found</p>  
@endif  
@endsection

@section('js_area')
    <script>
            var table = $('#printable').DataTable({
            dom: 'B',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn-sm btn-info p-0 px-3 m-1 ml-2 border border-light' },
                    { extend: 'csv', className: 'btn-sm btn-light p-0 px-3 m-1 border border-light' },
                    { extend: 'excel', className: 'btn-sm btn-success p-0 px-3 m-1 border border-light' },
                    { extend: 'pdf', className: 'btn-sm btn-danger p-0 px-3 m-1 border border-light' },
                    { extend: 'print', className: 'btn-sm btn-primary p-0 px-3 m-1 mx-2 border border-light' },
                ],
                dom: {
                    button: {
                        className: 'btn'
                    },
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            "paging":   false,
            "ordering": false,
            "info":     false,
            });
            table.buttons().container().appendTo('#exportbtns');

            var table2 = $('#printable2').DataTable({
            dom: 'Blfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn-sm btn-info p-0 px-3 m-1 ml-2 border border-light' },
                    { extend: 'csv', className: 'btn-sm btn-light p-0 px-3 m-1 border border-light' },
                    { extend: 'excel', className: 'btn-sm btn-success p-0 px-3 m-1 border border-light' },
                    { extend: 'pdf', className: 'btn-sm btn-danger p-0 px-3 m-1 border border-light' },
                    { extend: 'print', className: 'btn-sm btn-primary p-0 px-3 m-1 mx-2 border border-light' },
                ],
                dom: {
                    button: {
                        className: 'btn'
                    },
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "paging":   true,
            "ordering": false,
            "info":     true,
            });
            table2.buttons().container().appendTo('#exportbtns2');
            $('#printable2_filter').appendTo('#filterDiv');
    </script>
@endsection

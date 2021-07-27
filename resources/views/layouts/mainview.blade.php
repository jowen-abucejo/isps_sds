@extends('layouts.layout')

@section('content')
<div class="col-12 min-vh-100">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-7 mx-lg-auto bg-light rounded shadow mb-4 text-center p-5">
        @yield('active_view')
    </div> 
    <div class="table-responsive bg-danger">
        @yield('bottom_view')
    </div>
</div>
@endsection
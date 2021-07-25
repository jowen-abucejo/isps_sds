@extends('layouts.layout')

@section('content')
<div class="col-12 min-vh-100">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 bg-light rounded shadow mb-4 text-center p-5">
        @yield('active_view')
    </div> 
    @yield('bottom_view')
</div>
@endsection
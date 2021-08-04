@extends('layouts.mainview')

@section('active_view')
        <h4 class="mb-4">
            {{ ($read_user)? 'Update User\'s Account' : 'Register New User'  }}  
        </h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif  

        <form action="{{ route('su.users') }}" method="POST">
            @csrf
            @if ($read_user)
                <input type="hidden" name="toUpdate" value="{{ $read_user->id }}">
            @endif
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text"  name="name" id="name" placeholder="Name" class="form-control" value="{{ ($read_user)?$read_user->name : old('name')}}">
            </div>
            @error('name')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="text"  name="email" id="email" placeholder="Email Address" class="form-control" value="{{ ($read_user)?$read_user->email : old('email') }}">
            </div>
            @error('email')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-genderless"></i></span></div>
                <select name="usertype" id="usertype" class="form-control">
                    <option value="">** User Type **</option>
                    <option value="admin"  @if ($read_user){{ ($read_user->isAdmin())? "selected" : "" }} @endif>ADMIN</option>
                    <option value="student"  @if ($read_user){{ ($read_user->isStudent())? "selected" : ""  }} @endif>STUDENT</option>                    
                </select>
            </div>
            @error('usertype')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <button type="submit" class="btn btn-block mt-4 {{ ($read_user)? 'btn-success' : 'btn-info' }}">{{ ($read_user)? 'Update ' : 'Register'  }} Account</button>
            @if ($read_user)
                <a href="{{ route('su.users') }}" class="btn btn-block btn-info mt-4">Cancel Edit</a>
            @endif
        </form>
@endsection
@section('bottom_view')
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr>
                <th>User ID</th> 
                <th>Name</th> 
                <th>Email</th> 
                <th>Student ID</th>
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>@if($user->isStudent()){{ ($user->student)? $user->student->student_id : 'Student Profile Not Set' }} @else ADMIN @endif</td>
                <td>
                    {{-- <form action="{{ route('su.users') }}" method="post" class="btn btn-sm">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="toUpdate" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-sm  btn-danger">DELETE ACCOUNT</button>
                    </form> --}}
                    <a href="{{ route('su.users', ['user_id' => $user->id]) }}" class="btn btn-sm btn-info px-4"> EDIT </a>
                </td>
            </tr>
        @endforeach    
        </tbody>        
    </table>
@endsection
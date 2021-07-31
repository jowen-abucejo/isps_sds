@extends('layouts.mainview')

@section('active_view')
    <h4 class="mb-4">
        @if ($read_downloadable) 
            Update
        @else
            Upload New
        @endif Downloadable
    </h4 > 
    @if (session('status'))
        <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
    @endif  

    <form action="{{ route('su.downloadables') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($read_downloadable) <input type="hidden" name="toUpdate" value="{{ $read_downloadable->id }}">@endif
        <div class="input-group form-group mt-4 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-pen"></i></span>
            </div>
            <input type="text"  name="document_name" id="document_name" placeholder="Document Name" class="form-control" value="{{ ($read_downloadable)?$read_downloadable->document_name : old('document_name')}}" required>
        </div>
        @error('document_name')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror
        <div class="form-group text-left mb-3">
            <label for="file">Select File to Upload (PDF File only)</label>
            <input type="file" name="file" id="file" class="form-control-file border">
        </div>
        @error('file')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror
        @if ($read_downloadable) 
        <button type="submit" class="btn btn-block mt-4 btn-success">Update Document</button>
        <a class="btn btn-block btn-info mt-4" href="{{ route('su.downloadables') }}">Cancel Edit</a>
        @else
        <button type="submit" class="btn btn-block mt-4 btn-info">Upload Document</button>
        @endif
    </form>
@endsection
@section('bottom_view')
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr>
                <th colspan="2">Document Name</th> 
                <th colspan="1">Action</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($downloadables as $downloadable)
            <tr>
                <td colspan="2">{{ $downloadable->document_name }}</td>
                <td colspan="1">
                <form action="{{ route('su.downloadables') }}" method="post" class="btn btn-sm p-0">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="downloadable_id" value="{{ $downloadable->id }}">
                    <button type="submit" class="btn btn-sm btn-danger px-4 my-1">DELETE</button>
                </form>
                <a href="{{ route('downloadables.preview', ['downloadable_id' => $downloadable->id]) }}" class="btn btn-sm btn-info px-3 my-1" target="_blank">PREVIEW</a>
                <a href="{{ route('su.downloadables', ['downloadable_id' => $downloadable->id]) }}" class="btn btn-sm btn-info px-4 my-1"> EDIT </a>
                </td>          
            </tr>      
            @endforeach    
            <tr>
                <td colspan="3">
                    @if (!$downloadables->count())
                      <p class="d-block alert-warning">No Records Found</p>  
                    @endif
                </td>
            </tr>        
        </tbody>
    </table>
@endsection
@extends('layouts.mainview')

@section('active_view')
    <h4>Downloadables</h4>
@endsection
@section('bottom_view')
<div class="table-responsive">
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
                    <a href="{{ route('downloadables.preview', ['downloadable_id' => $downloadable->id]) }}" class="btn btn-sm btn-info px-3 my-1" target="_blank">PREVIEW</a>
                    <a href="{{ route('downloadables.download', ['downloadable_id' => $downloadable->id]) }}" class="btn btn-sm btn-success px-3 my-1" target="_blank">DOWNLOAD</a>
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
</div>
@endsection
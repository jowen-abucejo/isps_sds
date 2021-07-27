<?php

namespace App\Http\Controllers;

use App\Models\Downloadable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DownloadableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['student'])->only(['index']);
        $this->middleware(['admin'])->except(['index', 'preview', 'download']);
    }

    public function index()
    {
        $downloadables = Downloadable::where('status', 'AVAILABLE')->orderBy('document_name', 'asc')->get();        
        return view('student.downloadables', ['downloadables'=>$downloadables]);
    }

    public function preview(Request $request)
    {
        $to_preview = Downloadable::where('id', $request->downloadable_id)->first();
        return response()->file(storage_path('app/'.$to_preview->filename));
    }

    public function download(Request $request)
    {
        $to_download = Downloadable::where('id', $request->downloadable_id)->first();
        return response()->download(storage_path('app/'.$to_download->filename));
    }

    public function show(Request $request){
        $downloadables = Downloadable::orderBy('document_name', 'asc')->get();
        $read_downloadable = $downloadables->where('id', $request->downloadable_id)->first();
        return view('su.downloadables', ['downloadables' => $downloadables, 'read_downloadable' => $read_downloadable]);
    }

    public function save(Request $request)
    {
        $ignoreSelf = ($request->toUpdate)?? 0;
        $this->validate($request, [
            'document_name' => [
                'required',
                Rule::unique('downloadables')->where(function ($query) use ($request) {
                    return $query
                        ->where('document_name', $request->document_name);
                })->ignore($ignoreSelf),
            ],
            'file' => 'required|file|mimes:pdf',
        ], [
            'file.mimes' => 'Uploaded file must be a PDF type',
            'document_name.unique' => 'Document name already used.',
        ]);

        $path = 'downloadables';
        if($ignoreSelf === 0){
            if(Storage::exists($path.$request->document_name))
                return back()->with('status', 'The same file exist.');
            $storepath = Storage::putFile($path, $request->file('file'));
            Downloadable::create([
                'document_name' => $request->document_name,
                'filename' => $storepath,
            ]);
            return redirect()->route('su.downloadables')->with('status', 'Upload Success');
        }

        $to_update = Downloadable::where('id', $request->toUpdate)->first();
        if(!$to_update) return back()->with('status', 'The record to update don\'t exist');
        Storage::delete($to_update->filename);
        $storepath = Storage::putFile($path, $request->file('file', $request->document_name));
        $to_update->update([
            'document_name' => $request->document_name,
            'filename' => $storepath,        
        ]);
        return back()->with('status', 'Document Update Success.');
    }

    public function delete(Request $request)
    {
        $to_delete = Downloadable::where('id', $request->downloadable_id)->first();
        Storage::delete($to_delete->filename);
        $to_delete->forceDelete();
        return back()->with('status', 'Document Deleted!');
    }
}

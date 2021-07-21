<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScholarshipApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        if($request->user()->isAdmin()){
            return view('su.scholarships');
        }
    
        

    }
}

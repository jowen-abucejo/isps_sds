<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified', 'student']);
    }

    public function index(){
        return view('student.dashboard');
    }
}

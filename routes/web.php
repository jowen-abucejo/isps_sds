<?php

use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\GoogleSignInController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//----------------------Home--------------------
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/home', function () { return view('welcome'); });
Route::get('/signout', function(){ return view('welcome'); });

//----------------------Signout--------------------
Route::post('/signout', [SignInController::class, 'signout'])->name('auth.signout');

//----------------------Signup--------------------
Route::get('/signup', [SignUpController::class, 'index'])->name('auth.signup');
Route::post('/signup', [SignUpController::class, 'signup']);

//----------------------Signin--------------------
Route::get('/signin', [SignInController::class, 'index'])->name('auth.signin');
Route::post('/signin', [SignInController::class, 'signin']);

//----------------------Google Signin--------------------
Route::get('/auth/google', [GoogleSignInController::class, 'index'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleSignInController::class, 'signin'])->name('auth.googlecallback');

//----------------------Email Verification--------------------
Route::get('/email/verify', [EmailController::class, 'index'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'emailVerified'])->name('verification.verify');
Route::post('/email/verify', [EmailController::class, 'emailVerificationResend'])->name('verification.send');

//----------------------Password Reset--------------------
Route::get('/forgot-password', [PasswordController::class, 'requestReset'])->name('password.request');
Route::post('/forgot-password', [PasswordController::class, 'sendReset'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordController::class, 'newPass'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'updatePass'])->name('password.update');

//----------------------Student Profile--------------------
Route::get('/student/profile', [StudentController::class, 'index'])->name('student.profile');
Route::post('/student/profile', [StudentController::class, 'profile']);

//----------------------Student Dashboard--------------------
Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::post('/student/dashboard', [StudentDashboardController::class, 'save']);



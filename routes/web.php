<?php

use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\GoogleSignInController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\DownloadableController;
use App\Http\Controllers\ScholarshipApplicationController;
use App\Http\Controllers\Student\ApplicationFormController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Su\AdminDashboardController;
use App\Http\Controllers\Su\CourseController;
use App\Http\Controllers\Su\EnrolleeController;
use App\Http\Controllers\Su\RequirementController;
use App\Http\Controllers\Su\ScholarshipController;
use App\Http\Controllers\Su\UserController;
use App\Models\Downloadable;
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
Route::get('/home', function () { return redirect()->route('home'); });

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
Route::get('/auth/change-pass/', [PasswordController::class, 'changeOwnPass'])->name('pass.change');
Route::post('/auth/change-pass', [PasswordController::class, 'updateOwnPass'])->name('pass.update');


//-------------------------------------STUDENT--------------------------------------------
//----------------------Student Profile--------------------
Route::get('/student/profile', [StudentController::class, 'index'])->name('student.profile');
Route::post('/student/profile', [StudentController::class, 'profile']);

//----------------------Student Dashboard--------------------
Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
//Route::post('/student/dashboard', [StudentDashboardController::class, 'save']);

//----------------------Student Scholarships--------------------
Route::get('/student/scholarships/{scholarship_id?}', [StudentDashboardController::class, 'showScholarships'])->name('student.scholarships');
Route::post('/student/scholarships', [ScholarshipApplicationController::class, 'saveApplication']);

//----------------------Student Requirements--------------------
Route::get('/student/requirements/{sch_id?}', [ScholarshipApplicationController::class, 'requestRequirements'])->name('student.requirements');
Route::post('/student/requirements', [ScholarshipApplicationController::class, 'uploadRequirements']);

//----------------------Student Downloadables--------------------
Route::get('/student/downloadables/{downloadable_id?}', [DownloadableController::class, 'index'])->name('student.downloadables');
Route::get('/downloadables/preview/{downloadable_id}', [DownloadableController::class, 'preview'])->name('downloadables.preview');
Route::get('/downloadables/download/{downloadable_id}', [DownloadableController::class, 'download'])->name('downloadables.download');

//-------------------------------------ADMIN--------------------------------------------
//----------------------Courses--------------------
Route::get('/su/courses/{course_id?}', [CourseController::class, 'index'])->name('su.courses');
Route::post('/su/courses', [CourseController::class, 'save']);
Route::patch('/su/courses', [CourseController::class, 'changeStatus']);

//----------------------Scholarships--------------------
Route::get('/su/scholarships/{scholarship_id?}', [ScholarshipController::class, 'index'])->name('su.scholarships');
Route::post('/su/scholarships/', [ScholarshipController::class, 'save']);
Route::patch('/su/scholarships/', [ScholarshipController::class, 'changeStatus']);

//----------------------Admin Dashboard--------------------
Route::get('/su/dashboard', [AdminDashboardController::class, 'index'])->name('su.dashboard');

//----------------------Requirements--------------------
Route::get('/su/requirements/{requirement_id?}', [RequirementController::class, 'index'])->name('su.requirements');
Route::post('/su/requirements', [RequirementController::class, 'save']);
Route::patch('/su/requirements', [RequirementController::class, 'changeStatus']);

//------------------------Downloadables------------------------
Route::get('/su/downloadables/{downloadable_id?}', [DownloadableController::class, 'show'])->name('su.downloadables');
Route::post('/su/downloadables', [DownloadableController::class, 'save']);
Route::patch('/su/downloadables', [DownloadableController::class, 'delete']);

//-------------------------Admin Manage Scholarship Application-------------------
Route::get('/su/manage/{scholarship_code}/{application_id?}', [ScholarshipApplicationController::class, 'index'])->name('su.manage');
Route::post('/su/manage/approve', [ScholarshipApplicationController::class, 'manageApplication'])->name('su.manage.approved');
Route::patch('/su/manage', [ScholarshipApplicationController::class, 'delete']);
Route::get('/su/preview/requirements/{application_id}/{document_id}', [ScholarshipApplicationController::class, 'preview'])->name('su.requirement.preview');

//------------------------------Users--------------------------------
Route::get('/su/users/{user_id?}', [UserController::class, 'index'])->name('su.users');
Route::post('/su/users', [UserController::class, 'update']);

//------------------------------Enrollees--------------------------------
Route::get('/su/enrollees', [EnrolleeController::class, 'index'])->name('su.enrollees');
Route::post('/su/enrollees', [EnrolleeController::class, 'edit']);
Route::patch('/su/enrollees', [EnrolleeController::class, 'save']);

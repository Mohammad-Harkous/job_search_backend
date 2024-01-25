<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\JobApplicarionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// public routes

// for users
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Routes for job seeker
Route::get('/jobSeekers',[JobSeekerController::class, 'index']);
Route::get('/jobSeekers/{id}',[JobSeekerController::class, 'show']);
Route::put('/jobSeekers/{id}',[JobSeekerController::class, 'update']);
Route::delete('/jobSeekers/{id}',[JobSeekerController::class, 'destroy']);

// Routes for company
Route::get('/companyProfile',[CompanyController::class, 'index']);
Route::get('/companyProfile/{id}',[CompanyController::class, 'show']);
Route::put('/companyProfile/{id}',[CompanyController::class, 'update']);
Route::delete('/companyProfile/{id}',[CompanyController::class, 'destroy']);

// Routes for job
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/job/{id}', [JobController::class, 'show']);
Route::put('/job/{id}', [JobController::class, 'update']);
Route::delete('/job/{id}', [JobController::class, 'destroy']);

// Routes for job application
Route::get('/job-applications', [JobApplicarionController::class, 'index']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/profile', [JobSeekerController::class, 'store']);
    Route::post('/companyProfile', [CompanyController::class, 'store']);
    Route::post('/createJob', [JobController::class, 'store']);
    Route::post('/job-applications', [JobApplicarionController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
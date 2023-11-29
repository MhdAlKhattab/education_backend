<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitingController;
use App\Http\Controllers\AchievementController;

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

// For Test
Route::get('/test-online', function () {
    dd('Ok');
});

// Auth
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

// Visiting
Route::post('/visit',[VisitingController::class,'addVisiting']);

// Achievement
Route::post('/achievement',[AchievementController::class,'addAchievement']);

Route::group(['middleware' => 'auth:api'], function(){
    
    // Auth
    Route::post('/change-password',[authController::class,'changePassword']);

    // User
    Route::get('/user',[UserController::class,'me']);
    Route::put('/user',[userController::class,'update']);

    // Visiting
    Route::get('/visit',[VisitingController::class,'getVisitings']);
    Route::get('/visit/{query}',[VisitingController::class,'searchVisitings']);
    Route::delete('/visit/{id}',[VisitingController::class,'deleteVisiting']);

    // Achievement
    Route::get('/achievement',[AchievementController::class,'getAchievements']);
    Route::get('/achievement/{query}',[AchievementController::class,'searchAchievements']);
    Route::delete('/achievement/{id}',[AchievementController::class,'deleteAchievement']);
});



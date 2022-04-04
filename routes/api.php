<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/reset-password', [AuthController::class, 'reset_password']);
});

// Route::apiResource('user', UserController::class);

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function (){
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'], function (Request $request) {
        return $request->user()->token()->revoke();
    });

    Route::put('/update-profile/{user:id}', [UserController::class, 'updateProfile']);
    Route::put('/update-score/{user:id}', [UserController::class, 'updateScore']);
    Route::post('/update-profile-image/{user:id}', [UserController::class, 'updateProfileImage']);
    
    // function (Request $request) {
    //     return $request->file("file")->getClientOriginalName();
    // });
    
    Route::delete('/destroy/{user:id}', [UserController::class, 'destroy']);

});


Route::group(['prefix' => 'question', 'middleware' => ['auth:sanctum']], function (){
    Route::post('/questions', [QuestionController::class, 'questionsWithResponses']);
});
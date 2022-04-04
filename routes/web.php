<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;

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

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::get('/users', function () {
    //     return view('pages.users.index');
    // })->name('users.index');
    // Route::get('/users',[UserController::class, 'index'])->name('users.index');

    Route::prefix('users')->group(function () {
        Route::get('/list',[UserController::class, 'index'])->name('users.index');
        Route::delete('/user/delete/{user:id}',[UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/user/edit/{user:id}', [UserController::class, 'edit'])->name('users.edit'); 
        Route::put('/user/update/{user:id}', [UserController::class, 'update'])->name('users.update'); 
        Route::get('/user/edit-password/{user:id}', [UserController::class, 'edit_password'])->name('users.edit_password'); 
        Route::put('/user/update-password/{user:id}', [UserController::class, 'update_password'])->name('users.update_password');  
    });

    Route::prefix('questions')->group(function () {
        Route::get('/list', [QuestionController::class, 'index'])->name('questions.index');
        Route::get('/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/store', [QuestionController::class, 'store'])->name('questions.store');
        Route::delete('/question/delete/{question:id}',[QuestionController::class, 'destroy'])->name('questions.destroy');
        Route::get('/question/edit/{question:id}', [QuestionController::class, 'edit'])->name('questions.edit'); 
        Route::put('/question/update/{question:id}', [QuestionController::class, 'update'])->name('questions.update'); 
        Route::patch('/question/update_is_active', [QuestionController::class, 'update_is_active'])->name('questions.update_is_active');

        Route::get('/question/responses/assign/{question:id}', [QuestionController::class, 'assign'])->name('questions.assign');
    });

    Route::prefix('responses')->group(function () {
        Route::get('/list', [ResponseController::class, 'index'])->name('responses.index');
        Route::get('/create', [ResponseController::class, 'create'])->name('responses.create');
        Route::post('/store', [ResponseController::class, 'store'])->name('responses.store');
        Route::delete('/response/delete/{response:id}',[ResponseController::class, 'destroy'])->name('responses.destroy');
        Route::get('/response/edit/{response:id}', [ResponseController::class, 'edit'])->name('responses.edit'); 
        Route::put('/response/update/{response:id}', [ResponseController::class, 'update'])->name('responses.update'); 
        Route::patch('/response/update_is_active', [ResponseController::class, 'update_is_active'])->name('responses.update_is_active');
        Route::patch('/question/responses/random_assign/{question:id}', [ResponseController::class, 'random_assign'])->name('responses.random_assign');

    });
});
require __DIR__.'/auth.php';

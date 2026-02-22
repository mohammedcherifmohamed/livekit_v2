<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
});

use App\Http\Controllers\RoomController;
use App\Http\Controllers\CourseController;

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/meet/{room}', [RoomController::class, 'show'])->name('room.show');

    // Course management
    Route::get('/courses',                    [CourseController::class, 'index']) ->name('courses.index');
    Route::get('/courses/create',             [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses',                   [CourseController::class, 'store']) ->name('courses.store');
    Route::patch('/courses/{course}/launch',  [CourseController::class, 'launch'])->name('courses.launch');
    Route::patch('/courses/{course}/end',     [CourseController::class, 'end'])   ->name('courses.end');
});

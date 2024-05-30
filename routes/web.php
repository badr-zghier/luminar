<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherCoursesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'role:teacher'])->name('dashboard');

// Teacher Routes
Route::get('/courses', [TeacherCoursesController::class, 'index'])->middleware('auth', 'role:teacher')->name('courses');
Route::get('/course/{id}', [TeacherCoursesController::class, 'course'])->middleware('auth', 'role:teacher')->name('course');


Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

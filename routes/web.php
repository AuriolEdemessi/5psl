<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    CourseController,
    SectionController,
    ChapterController,
    MediaController,
    QuizController,
    QuestionController,
    AdminController,
    AnswerController
};

// Group routes for admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Course Management
    Route::resource('courses', CourseController::class);

    // Section Management
    Route::resource('sections', SectionController::class);

    // Chapter Management
    Route::resource('chapters', ChapterController::class);

    // Media Management
    Route::resource('medias', MediaController::class);

    // Quiz Management
    Route::resource('quizzes', QuizController::class);

    // Question Management
    Route::resource('questions', QuestionController::class);

    // Answer Management
    Route::resource('answers', AnswerController::class);
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

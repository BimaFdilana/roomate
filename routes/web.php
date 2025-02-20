<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

$router->aliasMiddleware('role', CheckRole::class);

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('home');

    Route::get('/classroom/{id}', [ClassroomController::class, 'show'])->name('classroom.show');

    Route::get('/material/{id}', [MaterialController::class, 'show'])->name('post.materialDetail');
    Route::get('/{type}/{id}', [PostController::class, 'detail'])->name('post.detail');
    Route::get('/material/{id}/download', [MaterialController::class, 'download'])->name('material.download');

    Route::get('/account', [SettingController::class, 'index'])->name('account');
    Route::post('/account/profile', [SettingController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/password', [SettingController::class, 'updatePassword'])->name('account.updatePassword');

});

Route::middleware(['role:murid'])->group(function () {
    Route::get('/quiz/{quiz}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    Route::get('/quiz/{quiz}/questions', [QuizController::class, 'getQuizQuestions']);
    Route::post('/join', [ClassroomController::class, 'joinClass'])->middleware('auth')->name('join-class');
    Route::post('/save-quiz-result', [QuizController::class, 'saveResult']);
});

Route::middleware(['role:guru'])->group(function () {
    Route::post('/classroom/store', [ClassroomController::class, 'store'])->middleware('auth')->name('classroom.store');

    Route::get('/classroom/{classroom_id}/material/post', [MaterialController::class, 'create'])->name('material_post');
    Route::post('/classroom/{classroom_id}/material', [MaterialController::class, 'store'])->name('material.store');
    Route::get('/classroom/{classroom_id}/material/{id}/edit', [MaterialController::class, 'edit'])->name('material.edit');
    Route::put('/classroom/{classroom_id}/material/{id}', [MaterialController::class, 'update'])->name('material.update');
    Route::delete('/classroom/{classroom_id}/material/{id}', [MaterialController::class, 'destroy'])->name('material.destroy');

    Route::get('/classroom/{classroom_id}/quizzes/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('/classroom/{classroom_id}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/classroom/{classroom_id}/quizzes/{id}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/classroom/{classroom_id}/quizzes/{id}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/classroom/{classroom_id}/quizzes/{id}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

});
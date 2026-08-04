<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('consultation.history');

    Route::get('/beginner', [ConsultationController::class, 'beginnerForm'])->name('consultation.beginner');
    Route::post('/beginner', [ConsultationController::class, 'beginnerProcess'])->name('consultation.beginner.process');

    Route::get('/intermediate', [ConsultationController::class, 'intermediateForm'])->name('consultation.intermediate');
    Route::post('/intermediate', [ConsultationController::class, 'intermediateProcess'])->name('consultation.intermediate.process');
    
    // Admin
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::post('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::get('/admin/questions', [App\Http\Controllers\AdminController::class, 'questions'])->name('admin.questions');
        Route::post('/admin/gold-price', [App\Http\Controllers\AdminController::class, 'updateGoldPrice'])->name('admin.goldprice.update');
        Route::post('/admin/questions', [App\Http\Controllers\AdminController::class, 'storeQuestion'])->name('admin.questions.store');
        Route::post('/admin/questions/{question}', [App\Http\Controllers\AdminController::class, 'updateQuestion'])->name('admin.questions.update');
        Route::delete('/admin/questions/{question}', [App\Http\Controllers\AdminController::class, 'destroyQuestion'])->name('admin.questions.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

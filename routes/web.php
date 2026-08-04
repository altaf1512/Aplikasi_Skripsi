<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultationController;

Route::get('/', [ConsultationController::class, 'index'])->name('home');

// Alur Pemula
Route::get('/beginner', [ConsultationController::class, 'beginnerForm'])->name('consultation.beginner');
Route::post('/beginner', [ConsultationController::class, 'beginnerProcess'])->name('consultation.beginner.process');

// Alur Menengah (Expert System)
Route::get('/intermediate', [ConsultationController::class, 'intermediateForm'])->name('consultation.intermediate');
Route::post('/intermediate', [ConsultationController::class, 'intermediateProcess'])->name('consultation.intermediate.process');

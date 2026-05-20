<?php
use App\Http\Controllers\QuizController;

Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/responder', [QuizController::class, 'responder'])->name('quiz.responder');
Route::post('/reiniciar', [QuizController::class, 'reiniciar'])->name('quiz.reiniciar');
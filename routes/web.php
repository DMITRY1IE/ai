<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenAIController;

Route::get('/', [OpenAIController::class, 'showForm'])->name('chat.form');
Route::post('/openai', [OpenAIController::class, 'processQuestion']);
Route::post('/clear-history', [OpenAIController::class, 'clearHistory'])->name('chat.clear');

<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VideoController;

Route::get('/', [ImageController::class, 'showHome']);
Route::post('/generate-image', [ImageController::class, 'generateImage'])->name('generate-image');
Route::post('/summarize-video', [VideoController::class, 'summarize'])->name('summarize-video');
Route::post('/translate-summary', [VideoController::class, 'translate'])->name('translate-summary');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;


// Halaman utama
// Home
Route::get('/', [AnimeController::class, 'index'])->name('home');

// Halaman List Episode (Prefix: show)
Route::get('/show/{folder_name}', [AnimeController::class, 'show'])->name('anime.detail');

// Halaman Video Player (Prefix: play)
Route::get('/play/{folder_name}/{eps}', [AnimeController::class, 'watch'])->name('anime.watch');

Route::get('/sync', [AnimeController::class, 'sync'])->name('anime.sync');

Route::get('/video-stream/{folder}/{file}', [AnimeController::class, 'streamVideo'])->name('video.stream');

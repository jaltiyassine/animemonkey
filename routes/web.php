<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimeListController;
use App\Http\Controllers\SeasonAnimeController;
use App\Http\Controllers\SuggestMeController;
use App\Http\Controllers\SearchAnimeController;
use App\Http\Controllers\watchController;

Route::get('/', [HomeController::class, 'index'])->name("home");
Route::get('/anime-list', [AnimeListController::class, 'index'])->name("anime-list");
Route::get('/season-anime', [SeasonAnimeController::class, 'index'])->name("season-anime");
Route::get('/suggest-me', [SuggestMeController::class, 'index'])->name("suggest-me");
Route::get('/anime/{jikanID}/{slug}/{title?}', [HomeController::class, 'anime'])->name("anime");
Route::get('/search', [SearchAnimeController::class, 'search'])->name("search");
Route::get('/search/list', [SearchAnimeController::class, 'searchList'])->name("search-list");
Route::get('/watch/{jikanID}/{slug}/{ep}', [watchController::class, 'anime'])->name("watch");
Route::post('/check-working-server', [watchController::class, 'checkWorkingServer'])->name("check");

// login / register
// dashboard
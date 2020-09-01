<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\SwaggerController;
use App\Http\Controllers\V1\ArticlesController;

Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');

Route::get('/swagger', [SwaggerController::class, 'index'])->name('swagger');

//Route::middleware(['auth:api'])->group(function () {

//    Route::get('/articles', [ArticlesController::class, 'index']);

//});

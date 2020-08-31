<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\SwaggerController;

Route::get('/swagger', [SwaggerController::class, 'index']);

//Route::middleware(['auth:api'])->group(function () {

//    Route::get('/articles', [ArticlesController::class, 'index']);

//});

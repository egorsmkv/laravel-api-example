<?php

use App\Http\Controllers\ErrorsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Sven\SuperBasicAuth\SuperBasicAuth;

Route::middleware(SuperBasicAuth::class)->group(function () {

    Route::get('/logs', [LogViewerController::class, 'index']);

});

Route::prefix('/auth')->middleware(['api'])->group(function () {

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');

});
Route::get('/login', [ErrorsController::class, 'loginRequired'])->name('login');

Route::get('/test/test1', [TestController::class, 'test1']);

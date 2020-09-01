<?php

use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Sven\SuperBasicAuth\SuperBasicAuth;
use App\Http\Controllers\ErrorsController;
use App\Http\Controllers\TestController;

Route::middleware(SuperBasicAuth::class)->group(function () {
    Route::get('/logs', [LogViewerController::class, 'index'])->name('logs');
});

Route::prefix('/auth')->middleware(['api'])->group(function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
});

Route::get('/login', [ErrorsController::class, 'loginRequired'])->name('login.old');

Route::get('/test/test1', [TestController::class, 'test1'])->name('test1');

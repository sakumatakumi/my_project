<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/top', [App\Http\Controllers\TopController::class, 'index']);
Route::get('/sample', [App\Http\Controllers\SampleController::class, 'index']);

//第8章
Route::get('/login', [App\Http\Controllers\LoginController::class, 'index']);

Route::post('/login/register', [App\Http\Controllers\LoginController::class, 'register']);

Route::post('/login/sign_up', [App\Http\Controllers\LoginController::class, 'sign_up']);

Route::get('/login/unregister', [App\Http\Controllers\LoginController::class, 'unregister']);

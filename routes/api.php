<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/cliente', [App\Http\Controllers\ClienteController::class, 'create']);
Route::get('/cliente/{id}', [App\Http\Controllers\ClienteController::class, 'listOne']);
Route::put('/cliente/{id}', [App\Http\Controllers\ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [App\Http\Controllers\ClienteController::class, 'delete']);
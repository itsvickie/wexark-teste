<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/cliente', [App\Http\Controllers\ClienteController::class, 'create']);
Route::get('/cliente/{id}', [App\Http\Controllers\ClienteController::class, 'listOne']);
Route::put('/cliente/{id}', [App\Http\Controllers\ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [App\Http\Controllers\ClienteController::class, 'delete']);

Route::post('/pastel', [App\Http\Controllers\PastelController::class, 'create']);
Route::get('/pastel/{id}', [App\Http\Controllers\PastelController::class, 'listOne']);
Route::get('/pastel', [App\Http\Controllers\PastelController::class, 'listAll']);
Route::post('/pastel/atualizar/{id}', [App\Http\Controllers\PastelController::class, 'update']);
Route::delete('/pastel/{id}', [App\Http\Controllers\PastelController::class, 'delete']);

Route::get('/pastel/tipo/list', [App\Http\Controllers\TipoPastelController::class, 'listAll']);
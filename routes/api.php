<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/cliente', [App\Http\Controllers\ClienteController::class, 'create']);
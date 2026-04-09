<?php

use App\Http\Controllers\Api\ResourceApiController;
use Illuminate\Support\Facades\Route;

Route::get('/resources', [ResourceApiController::class, 'index']);
Route::get('/resources/{resource}', [ResourceApiController::class, 'show']);

<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ItemController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/api/items', [ApiController::class, 'index']);
Route::post('/api/items', [ApiController::class, 'store']);
Route::get('/api/items/{id}', [ApiController::class, 'show']);
Route::put('/api/items/{id}', [ApiController::class, 'update']);
Route::delete('api/items/{id}', [ApiController::class, 'destroy']);

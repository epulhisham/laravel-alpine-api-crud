<?php

use App\Http\Controllers\ItemController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
include('api.php');

Route::get('/items', [ItemController::class, 'index'])->name('item.index');

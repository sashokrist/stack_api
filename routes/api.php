<?php

use App\Http\Controllers\KeyValueStoreController;
use App\Http\Controllers\StackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Stack routes
Route::post('/stack/add', [StackController::class, 'addItem']);
Route::get('/stack/get', [StackController::class, 'getItem']);

// Key-Value Store routes
Route::post('/key-value/add', [KeyValueStoreController::class, 'addKey']);
Route::get('/key-value/get', [KeyValueStoreController::class, 'getKey']);
Route::delete('/key-value/delete', [KeyValueStoreController::class, 'deleteKey']);

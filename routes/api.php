<?php

use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [RegisterUserController::class, 'store']);
Route::get('/users', [RegisterUserController::class, 'show']);
Route::get('/user/{id}', [RegisterUserController::class, 'user']);
Route::delete('/user/{id}/delete', [RegisterUserController::class, 'destroy']);

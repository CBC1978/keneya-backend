<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  \App\Http\Controllers\Api\SettingController;
use  \App\Http\Controllers\Api\UserController;

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

//Setting Route
Route::get('settings', [SettingController::class, 'index']);
Route::post('settings/create', [SettingController::class, 'store']);
Route::put('settings/edit/{setting}', [SettingController::class, 'update']);
Route::delete('settings/{setting}', [SettingController::class, 'delete']);

//User route
Route::post('/register', [UserController::class, 'register']);
Route::put('/user/edit/{id}', [UserController::class, 'update']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

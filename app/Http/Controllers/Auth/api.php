<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
Route::get('/getPost',  [AuthController::class, 'backgroundImage']);

Route::prefix('auth')->group(function () {
    Route::post('/login',  [AuthController::class, 'login']);
    Route::get('/logout',  [AuthController::class, 'logout']);
});

Route::group(['prefix'=>'auth','middleware'=>'auth'],function (){
    Route::get('/authUser',  [AuthController::class, 'authUser']);
});

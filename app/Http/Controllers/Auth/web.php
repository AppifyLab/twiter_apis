<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
Route::get('/getPost',  [AuthController::class, 'backgroundImage']);

Route::prefix('auth')->group(function () {
    Route::post('/login',  [AuthController::class, 'login']);
    Route::post('/register',  [AuthController::class, 'register']);
});

Route::group(['prefix'=>'auth','middleware'=>'auth'],function (){
    Route::get('/logout',  [AuthController::class, 'logout']);
    Route::get('/authUser',  [AuthController::class, 'authUser']);
    Route::post('/editAdminUser',  [AuthController::class, 'editAdminUser']);
    Route::post('/editAdminPassword',  [AuthController::class, 'editAdminPassword']);

});

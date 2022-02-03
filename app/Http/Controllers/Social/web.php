<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY... 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Social\SocialController;


Route::prefix('social')->group(function () {
    
   
    Route::get('/login',  [SocialController::class, 'login']);
    Route::get('/facebookredirect',  [SocialController::class, 'facebookredirect']);
    Route::get('/featchTweetes',  [SocialController::class, 'featchTweetes']);
    Route::get('/postInstagramForFirstTime',  [SocialController::class, 'postInstagramForFirstTimeActivate']);
    
    

});





<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY... 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Social\SocialController;


Route::prefix('social')->group(function () {
    Route::get('/login',  [SocialController::class, 'login']);
    Route::get('/facebookredirect',  [SocialController::class, 'facebookredirect']);
    Route::get('/getFbPage',  [SocialController::class, 'getFbPage']);
    Route::get('/instagramAccountId',  [SocialController::class, 'instagramAccountId']);
    Route::get('/instagramAccountDetail',  [SocialController::class, 'instagramAccountDetail']);
    Route::get('/instagramPublishPhoto',  [SocialController::class, 'instagramPublishPhoto']);
    Route::get('/fbinfo',  [SocialController::class, 'fbinfo']);
    Route::get('/getTwites',  [SocialController::class, 'getTwites']);
    Route::get('/getTodaysPost',  [SocialController::class, 'getTodaysPost']);

});





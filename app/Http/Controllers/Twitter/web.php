<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Twitter\TwitterController;


Route::group(['prefix'=>'twitter','middleware'=>'auth'],function (){
   
    
    
    Route::post('/addTwitterUser',  [TwitterController::class, 'addTwitterUser']);
    Route::post('/editTwitterUser',  [TwitterController::class, 'editTwitterUser']);
    Route::post('/deleteTwitterUser',  [TwitterController::class, 'deleteTwitterUser']);
    Route::get('/getAlltwitterData',  [TwitterController::class, 'getAlltwitterData']);

    Route::get('/getAllTwitterPostList',  [TwitterController::class, 'getAllTwitterPostList']);
    Route::get('/geTwitterUser',  [TwitterController::class, 'getTwitterUser']);


});

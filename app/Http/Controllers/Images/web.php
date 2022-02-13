<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Images\ImagesController;


Route::group(['prefix'=>'images','middleware'=>'auth'],function (){
    Route::post('/iviewShowImage',  [ImagesController::class, 'iviewShowImage']);

    Route::post('/imageUpload',  [ImagesController::class, 'imageUpload']);
    Route::post('/deleteImageRow',  [ImagesController::class, 'deleteImageRow']);

    Route::get('/showAllImages',  [ImagesController::class, 'showAllImages']);
});

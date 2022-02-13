<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FontAndColor\FontAndColorController;


Route::group(['prefix'=>'fontandcolor','middleware'=>'auth'],function (){
    Route::post('/addFontAndColor',  [FontAndColorController::class, 'addFontAndColor']);
    Route::get('/viewFontAndColor',  [FontAndColorController::class, 'viewFontAndColor']);
});

<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY... 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Example\ExampleController;


Route::prefix('example')->group(function () {
    Route::get('/exampleRoute',  [ExampleController::class, 'exampleMethod']);
    Route::get('/processImage',  [ExampleController::class, 'processImage']);

});

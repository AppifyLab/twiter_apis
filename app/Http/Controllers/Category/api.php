<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\CategoryController;


Route::group(['prefix'=>'category','middleware'=>'auth'],function (){
    Route::post('/editAdminUser',  [CategoryController::class, 'editAdminUser']);
    Route::post('/editAdminPassword',  [CategoryController::class, 'editAdminPassword']);
    Route::get('/stath',  [CategoryController::class, 'getstath']);
    
    
    //=============================== Categoris-Start ==================================
    Route::post('/addCategory',  [CategoryController::class, 'addCategory']);
    Route::post('/editCategory',  [CategoryController::class, 'editCategory']);
    Route::post('/deleteCategory',  [CategoryController::class, 'deleteCategory']);
    Route::get('/getAlltwitterData',  [CategoryController::class, 'getAlltwitterData']);
    Route::get('/getAllTwitterPostList',  [CategoryController::class, 'getAllTwitterPostList']);

    
    //=============================== Categoris-End ==================================


    //=============================== Admin-sTart ==================================
    Route::post('/createAdmin',  [CategoryController::class, 'createAdmin']);
    Route::post('/editAdmin',  [CategoryController::class, 'editAdmin']);
    Route::post('/deleteAdmin',  [CategoryController::class, 'deleteAdmin']);
    Route::get('/getAllAdmins',  [CategoryController::class, 'getAllAdmins']);
    //=============================== Admin-End ==================================

});

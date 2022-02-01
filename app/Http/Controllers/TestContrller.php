<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestContrller extends Controller
{
    //
    public function insertIntoQueueForPostInstagram(){
        \Log::info("hello");
    }
}

<?php

namespace App\Http\Controllers\Social;

use App\Models\Category;
use App\Models\Twitter;
class SocialQuery
{

    public function singleTwitterUser(){

        return Category::first();
    }
    public function getTodaysPost($data,$start,$end){

        return Twitter::where('is_published',0)->whereDate('create_time','>=', $data)->get();
    }
    public function updateTwiterPost($id){

        return Twitter::where('id',$id)->update(['is_published'=>1]);
    }
    
}

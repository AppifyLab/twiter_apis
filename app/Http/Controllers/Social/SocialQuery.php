<?php

namespace App\Http\Controllers\Social;

use App\Models\Category;
use App\Models\Twitter;
use App\Models\User;
class SocialQuery
{

    public function singleTwitterUser(){
        return Category::first();
    }
    public function updateUser($token,$id){
        return User::where('id', $id)->update(['fb_token'=>$token,'is_connected'=>1]);
    }
    public function updateTwitesStatus($ids,$status){
        return Twitter::whereIn('id',$ids)->where('is_published','!=','Completed')->update(['is_published'=>$status]);
    }
    
    public function postInstagramForFirstTimeActivate($id){
        return   User::where('id',$id)->update(['is_ins_scheduled'=>1]);

    }
    public function insertIntoQueueForPostInstagram(){
        return   User::with('post')->whereHas('post')->get();

    }
    
    public function updateTwiterPost($id){

        return Twitter::where('id',$id)->update(['is_published'=>'Completed']);
    }

      // new methods
      public function updateCommonUser($data){
        return User::where('id', $data['id'])->update($data);
    }
    
}

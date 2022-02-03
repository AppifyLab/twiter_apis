<?php

namespace App\Http\Controllers\Twitter;

use App\Models\Twitter;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class TwitterQuery
{
   

  
    public function insertTwitters($data)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }
  
    //================================ Twitter-Start ========================================
    public function addTwitterUser($data){
        return Category::create($data);
    }
    public function editTwitterUser($data){
        $id = $data["cat_id"] ?? 0;
        unset($data["cat_id"]);
        return Category::where('id', $id)->where('user_id', $data['user_id'])->update($data);
    }
    public function updateTwites($data){
        return Category::where('id', $data['id'])->update($data);
    }
    public function deleteTwitterUser($data){
        $id = $data["cat_id"] ?? 0;
        return Category::where('id', $id)->delete();
    }
    public function getAlltwitterData($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        return Category::where('user_id',$data['user_id'])->when($str, function($q) use($str){
            $q->where('username', 'like', $str);
        })->orderByDesc('id')->paginate(10);
    }

    public function getAllTwitterPostList($data){
       return Twitter::where('user_id', $data['user_id'])->paginate(10);
    }   
    //================================ Twitter-End ========================================
    
}

<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Models\User;
use App\Models\Twitter;
use Illuminate\Database\Eloquent\Builder;

class CategoryQuery
{
   

    public function checkUser($id,$email)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }
    public function insertTwitters($data)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }
    
    
    public function editAdminUser($key, $value, $user){
        return User::where($key, $value)->update($user);
    }
    public function getSingleUser($key, $value){
        return User::where($key, $value)->first();
      }
    //================================ Category-Start ========================================
    public function addCategory($data){
        return Category::create($data);
    }
    public function editCategory($data){
        $id = $data["cat_id"] ?? 0;
        unset($data["cat_id"]);
        return Category::where('id', $id)->where('user_id', $data['user_id'])->update($data);
    }
    public function updateTwites($data){
        return Category::where('id', $data['id'])->update($data);
    }
    public function deleteCategory($data){
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
    //================================ Category-End ========================================


    //================================ Admin-start ========================================
    public function createAdmin($data){
        return User::create($data);
    }
    public function editAdmin($data){
        $uid = $data['uid'] ?? 0 ;
        unset($data['uid']);
        return User::where('id', $uid)->update($data);
    }
    public function getAllAdmins($data){
        return User::orderByDesc('id')->paginate(10);
    }
    public function deleteAdmin($data){
        $id = $data["uid"] ?? 0;
        return User::where('id', $id)->delete();
    }
    //================================ Admin-End ========================================
}

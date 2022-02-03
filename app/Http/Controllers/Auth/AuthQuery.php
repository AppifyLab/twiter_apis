<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
class AuthQuery
{

    public function register($data)
    {
        return User::create($data);

    }
    public function checkUser($id,$email)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }
    public function editAdminUser($key, $value, $user){
        return User::where($key, $value)->update($user);
    }
    public function getSingleUser($key, $value){
        return User::where($key, $value)->first();
    }
}

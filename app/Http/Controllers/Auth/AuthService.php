<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
class AuthService
{
    private $authQuery;
    public function __construct(AuthQuery $authQuery)
    {
        $this->authQuery = $authQuery;
    }

    public function login($data){

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'] ])) {
            return Auth::user();
        }
        else{
            return response()->json([
                'message' => "Invalid Creadentials.",
            ],401);
        }
    }
    public function register($data){
        $data['password'] = Hash::make($data['password']);
        return $this->authQuery->register($data);
    }

    public function editAdminUser($data){

        $auth = Auth::user();
        if(!$auth || $auth['id'] !=$data['id']){
            return response()->json([
                'message' => "Your are not authorised User!.",
            ],401);
          }
          $user =  $this->authQuery->checkUser($auth['id'], $data['email']);
    
          if($user){
             return response()->json([
                 'message' => "Email must be unique!.",
             ],401);
          }
    
          return $this->authQuery->editAdminUser('id',$data['id'], [
            "username"=> $data['username'],
            "email"=>$data['email']
          ]);
 
    }
    public function editAdminPassword($data){
     $auth = Auth::user();
     if(!$auth || $auth['id'] !=$data['id']){
         return response()->json([
             'message' => "Your are not authorised User!.",
         ],401);
       }
       $userInfo  =  $this->authQuery->getSingleUser('id',$data['id']);
 
       $check = Hash::check($userInfo['password'], $data['currentPassword']);
       if (!$check) {
         return response()->json([
             'message' => "Current password doesn`t match!",
         ],401);
       }
       return $this->authQuery->editAdminUser('id',$data['id'], [
         "password"=> Hash::make($data['newPassword']),
       ]);
         return $this->authQuery->editAdminPassword($data);
     }
 
     public function updatePassword($data)
     {
         if( $data['id'] != Auth::id()){
             return response()->json([
               'message' => "You are not Authenticate Admin!",
             ], 401);
          }
          
          $admin = $this->authQuery->getSingleUser('id', $data['id']);
         //  \Log::info($admin);
         //  return $admin['password'] ;
          
          if($admin){
              
             $checkOld =Hash::check($data['currentPassword'], $admin->password );
             $checkNew =Hash::check($data['newPassword'], $admin->password );
             
             if(!$checkOld){
               return response()->json([
                 'message' => "Password does not match to our records!",
               ], 401);
             }
             if($checkNew){
               return response()->json([
                 'updated' => "Password is already been taken!",
               ], 401);
             }
             
          }else{
             
                 return response()->json([
                   'message' => "Password does not exists !",
                 ], 401);
              
          }
         
         return $this->authQuery->editAdminUser('id',$data['id'], [
             "password"=>Hash::make($data['newPassword'])
           ]);
       
     }

    

}



<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image;
use File;
use Facebook\Facebook;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{






    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    public function login(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'email'   => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ],[
            'email.exists' => "Invalid Creadentials.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }

        return $this->authService->login($data);
    }
    public function register(Request $request){
        $data = $request->all();
        $user =  $this->authService->register($data);
        if($user){
           return $this->authService->login($data);
        }
        else {
            return response()->json([
                'messages' => "Invalid request"
            ], 401);
        }
    }

    public function editAdminUser(Request $request){
        $data = $request->all();
        return $this->authService->editAdminUser($data);
   }
   public function editAdminPassword(Request $request){
        $data = $request->all();
        return $this->authService->updatePassword($data);
    }
    public function logout(){
         Auth::logout();
         return response()->json(['message' => 'Logout Successfully !'], 200);
    }
    public function authUser(){
        return Auth::user();
    }
    
    
}

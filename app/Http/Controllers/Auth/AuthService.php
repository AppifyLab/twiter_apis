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

    

}



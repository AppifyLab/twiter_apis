<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
class AuthQuery
{

    public function register($data)
    {
        return User::create($data);

    }
}

<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthenticateUser
{
    public function authenticate($request)
    {
        $username=$request->post(Config('fortify.username'));
        $password=$request->post('password');

        $user=Admin::where('username','=',$username)
        ->orwhere('email','=',$username)
        ->orWhere('phone_number','=',$username)
        ->first();

        if($user && Hash::check($password,$user->password))
        {
            return $user;
        }
        return false;
    }
}
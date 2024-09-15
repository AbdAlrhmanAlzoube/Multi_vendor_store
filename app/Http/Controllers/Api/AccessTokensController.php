<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'device_name' => 'string|max:255',
            'ablities'=>'nullable|array'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->input('device_name', $request->userAgent());

            $token = $user->createToken($device_name,$request->post('ablities'));

            return Response::json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }

        return Response::json([
            'message' => 'Invalid credentials',
        ], 401); // 401 Unauthorized
    }

    public function destroy($token = null)
    {
        $user=FacadesAuth::guard('sanctum')->user();
        $personalAccessToken=PersonalAccessToken::findToken($token);

        //Revoke all tokens
        //$user->tokens()->delete(); EX:facebook exit all device

        if(null === $token)
        {
            $user->currentAccessToken()->delete();
            return;
    }

        if($user->id ==$personalAccessToken->tokenable_id 
        && get_class($user) ==$personalAccessToken->tokenable_type ){
            $personalAccessToken->delete();
        }

    }
}

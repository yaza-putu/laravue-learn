<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    protected $username = 'username';

    public function __construct()
    {
        $this->username = $this->findUsername();
    }

    public function findUsername()
    {
        $login = request()->input('username');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');            
        if(! $token = Auth::guard('user_api')->attempt([$this->username() => $credentials['username'], 'password' => $credentials['password']])){
            return response()->json(['msg' => 'Username Password Salah'], 401);
        }else{           
            return $this->respondWithToken($token);
        }
    }

    public function me()
    {
        return response()->json(auth('user_api')->user());
    }

    public function logout()
    {
        auth('user_api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('user_api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user_api')->factory()->getTTL() * 60,
        ]);
    }
}

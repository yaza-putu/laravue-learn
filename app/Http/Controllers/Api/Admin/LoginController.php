<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
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
        if(! $token = Auth::guard('admin_api')->attempt([$this->username() => $credentials['username'], 'password' => $credentials['password']])){
            return response()->json(['msg' => 'Username Password salah'], 401);
        }else{           
            return $this->respondWithToken($token);
        }
    }

    public function logout(Request $request)
    {
        auth('admin_api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json(auth('admin_api')->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->respondWithToken(auth('admin_api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin_api')->factory()->getTTL() * 60,
        ]);
    }

}

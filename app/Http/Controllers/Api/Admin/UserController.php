<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\Admin\UserResources;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('updated_at','desc')->get();
        return response()->json([
            'status'=>'success',
            'message'=>'Data success loaded',
            'data'  => UserResources::collection($user),
        ],200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if($user)
        {
            return response()->json([
                'status'=>'success',
                'message'=>'Data success loaded',
                'data'  => new UserResources($user),
            ],200);
        }
        else
        {
            return response()->json([
                'status'=>'error',
                'error_code'=>404,
                'message'=>'Data tidak ditemukan',
                'data'  => null,
            ],404);
        }
        
    }

    public function create(Request $request)
    {
        $data_user = $request->only(['username','password','email','name']);
        $messages =[
            'username.required' => 'Username tidak boleh kosong',
            'username.unique'   => 'Username sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 6 karakter',
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah digunakan',
            'name.required'     => 'Nama tidak boleh kosong',       
        ];
        $validator = Validator::make($data_user,[
            'username'  => 'required|unique:users',
            'password'  => 'required|min:6',
            'email'     => 'required|email|unique:users',
            'name'      => 'required',
        ],$messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'error_code' => 400,
                'messages' => $validator->errors()->all(),
            ],400);
        }

        try {
            $user = new User;
            $user->name =  $data_user['name'];
            $user->username = $data_user['username'];
            $user->password = Hash::make($data_user['password']);
            $user->email = $data_user['email'];
            $user->save();
            return response()->json([
                'status'=>'success',
                'message'=>'Data berhasil disimpan',
                'data'  => null,
            ],200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'error_code' => 500,
                'messages' => $e->getMessage(),
            ],500);
        }

    }

    public function update(Request $request)
    {
        $data_user = $request->only(['id','username','password','email','name']);
        $messages =[
            'username.required' => 'Username tidak boleh kosong',
            'username.unique'   => 'Username sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 6 karakter',
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah digunakan',
            'name.required'     => 'Nama tidak boleh kosong',       
        ];
        $validator = Validator::make($data_user,[
            'username'  => ['required',Rule::unique('users')->ignore($data_user['id'])],
            'password'  => 'required|min:6',
            'email'     => ['required','email',Rule::unique('users')->ignore($data_user['id'])],
            'name'      => 'required',
        ],$messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'error_code' => 400,
                'messages' => $validator->errors()->all(),
            ],400);
        }

        try {
            $user = User::findOrFail($data_user['id']);
            $user->name =  $data_user['name'];
            $user->username = $data_user['username'];
            $user->password = Hash::make($data_user['password']);
            $user->email = $data_user['email'];
            $user->save();
            return response()->json([
                'status'=>'success',
                'message'=>'Data berhasil disimpan',
                'data'  => null,
            ],200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'error_code' => 500,
                'messages' => $e->getMessage(),
            ],500);
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Data berhasil dihapus',
                'data'  => null,
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'error_code' => 400,
                'messages' => 'Data tidak ditemukan',
            ],400);
        }
    }

}

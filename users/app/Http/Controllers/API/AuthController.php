<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email atau kata sandi salah'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:5', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $validator->errors(),
                'data' => NULL
            ]);
        }

        $user =  User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        if ($user) {
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'User berhasil didaftarkan.',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Ada kesalahan sistem',
                'data' => NULL
            ]);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'token_type' => 'bearer',
            'expires_in' => 360 * 60
        ]);
    }
}

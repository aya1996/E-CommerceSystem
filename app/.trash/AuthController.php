<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if(Auth::guard('admin-api')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Invalid login details'
                ], 401); 
            }

            $user = User::where('email', $request['email'])->firstOrFail();

            // $token = $user->createToken('auth_token')->plainTextToken;
            
            $token = auth()->guard('admin-api')->user()->createToken('authToken')->accessToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
    }

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|confirmed',

        ]);
        $user = User::create([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'password'  => Hash::make($attr['password']),
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;
        $response = [
            'user'     => $user->only(['name', 'email']),
            'token'    => $token
        ];
        return response($response, 201);


        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        // $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        // $success['name'] =  $user->name;

        // return $this->handleResponse($success, 'User successfully registered!');
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }
}

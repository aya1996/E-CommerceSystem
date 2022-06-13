<?php

namespace App\Http\Controllers\API\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->get('remember'))) 
        {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ], 200);
        } 
      
        return response()->json(['error' => 'Unauthenticated'], 401);
      




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

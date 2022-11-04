<?php

namespace App\Http\Controllers\API\Authenticate;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        $userToken = $user->createToken('user-token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $userToken
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $user = Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);

        if (!$user) {
            return response([
                'message' => 'bad credentials!'
            ], 401);
        }

        $userToken = auth()->user()->createToken('user-token')->plainTextToken;

        return response([
            'user' => auth()->user(),
            'token' => $userToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'User logout successfully'
        ]);
    }

    public function authUser()
    {
        return response(auth()->user());
    }
}

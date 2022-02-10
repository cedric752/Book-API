<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

/**
 * @group Auth
 *
 * APIs for managing authors
 */
class AuthController extends Controller
{
    /**
     * auth.register
     *
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * auth.login
     *
     */
    public function login(LoginRequest $request)
    {
        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 200);
    }

    /**
     * auth.me
     * @authenticated
     */
    public function me(Request $request)
    {
        return $request->user();
    }

    /**
     * auth.logout
     * @authenticated
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}

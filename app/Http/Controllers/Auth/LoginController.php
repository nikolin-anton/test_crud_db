<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ErrorResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): UserResource|\Illuminate\Http\JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remeber)) {
            return UserResource::make(Auth::user());
        } else {
            throw new ErrorResponseException('invalid_credentials', 422);
        }
    }

    /** Logout User
     *
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        auth('sanctum')->user()->tokens()->delete();

        return response()->json(['message' => 'Ok'], 200);
    }
}

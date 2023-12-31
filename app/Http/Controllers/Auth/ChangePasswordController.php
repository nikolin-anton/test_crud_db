<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ErrorResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * @throws ErrorResponseException
     */
    public function __invoke(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        if (! (Hash::check($request->get('current_password'), auth('sanctum')->user()->password))) {

            throw new ErrorResponseException('password_does_not_matches', 422);
        } else {

            User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);

            return response()->json(['message' => 'Password successfully changed!'], 200);
        }
    }
}

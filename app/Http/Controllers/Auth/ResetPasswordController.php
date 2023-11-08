<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ErrorResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RessetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /**
     * @param RessetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ErrorResponseException
     */
    public function __invoke(RessetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->createToken('auth-token');

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status == Password::PASSWORD_RESET){
            return response()->json('Password reset successfully', 200);
        }else{
            throw new ErrorResponseException($status, 401);
        }
    }
}

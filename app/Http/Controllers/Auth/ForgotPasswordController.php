<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ErrorResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * @throws ErrorResponseException
     */
    public function __invoke(ForgotPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'A letter has been sent to your mail'], 200);
        } else {
            throw new ErrorResponseException($status, 401);
        }
    }
}

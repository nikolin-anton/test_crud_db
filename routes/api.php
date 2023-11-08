<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
   Route::post('/registration', RegistrationController::class);
   Route::post('/login', [LoginController::class, 'login']);
   Route::post('/logout', [LoginController::class, 'logout']);
   Route::post('/forgot-password', ForgotPasswordController::class);
   Route::post('/reset-password', ResetPasswordController::class);

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('/change-password', ChangePasswordController::class);
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, UserController, TestController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('email_confirmation', [AuthController::class, 'emailConfirmation']);
        Route::post('password_recovery', [AuthController::class, 'passwordRecovery']);
        Route::post('password_reset_code_check', [AuthController::class, 'passwordResetCodeCheck']);
        Route::post('password_reset', [AuthController::class, 'passwordReset']);
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
    });
    
});


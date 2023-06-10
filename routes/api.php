<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TrainerController;
use App\Http\Controllers\Api\TrainerAttendanceController;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

Route::post('/forget-password', [ForgetPasswordController::class, 'forgetPassword']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('subscribers', [SubscriberController::class, 'index']);
    Route::post('complaints/store', [App\Http\Controllers\Api\ComplaintController::class, 'store']);
    Route::prefix('trainer')->group(function () {
        Route::put('/changePassword', [TrainerController::class, 'changePassword']);
        Route::post('/attendances_store', [TrainerAttendanceController::class, 'attendances_store']);
        Route::post('/attendances_store', [TrainerAttendanceController::class, 'attendances_store']);
        Route::post('/departure', [TrainerAttendanceController::class, 'departure']);
        Route::get('/index', [TrainerAttendanceController::class, 'index']);
        Route::get('/ratings', [RatingController::class, 'ratings']);
    });

});
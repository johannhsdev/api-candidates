<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\CandidateController;
use Illuminate\Support\Facades\Route;

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

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('v1/candidates', CandidateController::class)
        ->only(['index', 'store', 'show']);
});

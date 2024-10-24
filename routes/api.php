<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('orders', OrderController::class);
});

/**
 * @OA\Get(
 *     path="/sanctum/csrf-cookie",
 *     summary="Get CSRF Cookie for authentication through Sanctum",
 *     tags={"Auth"},
 *     @OA\Response(
 *         response=204,
 *         description="CSRF cookie is set"
 *     )
 * )
 */
Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->noContent();
});

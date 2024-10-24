<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Order Tracking API",
 *     version="1.0.0",
 *     description="API for managing orders, including creating, updating, and deleting orders."
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter the Bearer token to authorize",
 *     name="Authorization",
 *     in="header"
 * )
 */
class ApiDocumentationController extends Controller
{
}

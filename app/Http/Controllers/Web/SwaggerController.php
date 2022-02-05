<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="0.0.1",
 *      title="Enkpay Authentication Microservice API Documentation",
 *      description="Authentication and Verification functionality",
 *      @OA\Contact(
 *          email="webmaster@enkpay.com"
 *      ),
 * )
 */

/**
 *  @OA\Server(
 *      url="http://localhost/api",
 *      description="Host"
 *  )
 *
 */

/**
 * @OA\SecurityScheme(
 *   securityScheme="Authorization",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 */

/**
 * @OA\Post(
 *     path="/auth/register",
 *     summary="Register User",
 *     tags={"Authentication API"},
 *    @OA\Parameter(
 *           name="last_name",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Parameter(
 *           name="first_name",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Parameter(
 *           name="phone_country",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Parameter(
 *           name="phone",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Parameter(
 *           name="account_type",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Parameter(
 *           name="password",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Parameter(
 *           name="password_confirmation",
 *           in="query",
 *           required=true,
 *           @OA\Schema(
 *                 type="string"
 *           )
 *     ),
 *    @OA\Response(
 *      response=200,
 *       description="Success",
 *   ),
 *   @OA\Response(
 *      response=400,
 *      description="Bad Request"
 *   ),
 *   @OA\Response(
 *      response=404,
 *      description="not found"
 *   ),
 *    @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *    ),
 *      security={
 *         {"Authorization":{}}
 *     },
 * )
 */

class SwaggerController extends Controller
{
    //
}

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

class SwaggerController extends Controller
{
    //
}

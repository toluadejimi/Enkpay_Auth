<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 *  @OA\Server(
 *      url="http://localhost/api/auth",
 *      description="Host"
 *  )
 *
 */

/**
 * @OA\SecurityScheme(
 *   securityScheme="Bearer Authorization",
 *   type="apiKey",
 *   in="header",
 *   name="Bearer Authorization"
 * )
 */

/**
 * @OA\Info(
 *      version="0.0.1",
 *      title="Enkpay Authentication Service API",
 *      description="Authentication and Verification Service API Documentation.",
 *      @OA\Contact(
 *          email="webmaster@enkpay.com"
 *      ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

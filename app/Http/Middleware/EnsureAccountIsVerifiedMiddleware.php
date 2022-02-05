<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAccountIsVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! \Auth::user()->accountIsVerified()) {
            return response([
                'success' => false,
                'message' => 'Account not verified',
            ], 403);
        }

        return $next($request);
    }
}

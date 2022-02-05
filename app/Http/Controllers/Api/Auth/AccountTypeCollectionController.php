<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\AccountTypeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AccountTypeCollectionController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $result = collect(AccountTypeEnum::toArray())
            ->reject(function ($key, $value) {
                if (Auth::check()) {
                    return Auth::user()->hasRole('admin') ?? $value === 'admin';
                }

                return $value === 'admin';
            })->all();

        return response()->json($result);
    }
}

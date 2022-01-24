<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function __invoke(): string
    {
        return "Hello, I don't expect you to be here, please use the api.";
    }
}

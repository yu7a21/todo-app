<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return "hello,world";
    }
}

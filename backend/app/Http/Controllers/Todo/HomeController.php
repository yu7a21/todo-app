<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\UseCase\TodoUseCase;

class HomeController extends Controller
{
    public function __invoke(TodoUseCase $use_case)
    {
        return $use_case->home();
    }
}

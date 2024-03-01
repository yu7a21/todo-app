<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\UseCase\TodoUseCase;

class HomeController extends Controller
{
    public function __invoke(TodoUseCase $use_case)
    {
        $datas = $use_case->home();

        return view("home", ["title"=>'Home', "datas" => $datas]);
    }
}

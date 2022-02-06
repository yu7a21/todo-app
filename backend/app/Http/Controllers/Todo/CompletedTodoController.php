<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\UseCase\TodoUseCase;

class CompletedTodoController extends Controller
{
    public function __invoke(TodoUseCase $use_case)
    {
        $datas = $use_case->completedTodo();
        return view("home", ["title"=>'おわったタスク', "datas" => $datas]);
    }
}

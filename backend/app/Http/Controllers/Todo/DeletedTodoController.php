<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\UseCase\TodoUseCase;

class DeletedTodoController extends Controller
{
    public function __invoke(TodoUseCase $use_case)
    {
        $datas = $use_case->deletedTodo();
        return view("home", ["title"=>'やめたタスク', "datas" => $datas]);
    }
}

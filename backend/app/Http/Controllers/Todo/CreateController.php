<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\Domain\TodoCreateForm;
use App\TodoApp\Todo\UseCase\TodoUseCase;

use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request, TodoUseCase $use_case)
    {
        $todo_form = new TodoCreateForm($request->all());
        $use_case->create($todo_form);
        return redirect()->route('home');
    }
}

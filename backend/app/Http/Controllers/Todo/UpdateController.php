<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\Domain\TodoUpdateForm;
use App\TodoApp\Todo\UseCase\TodoUseCase;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request, TodoUseCase $use_case)
    {
        $todo_form = new TodoUpdateForm($request->all());
        $use_case->update($todo_form);
        return redirect()->route('home');
    }
}

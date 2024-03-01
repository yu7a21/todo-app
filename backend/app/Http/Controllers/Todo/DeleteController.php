<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;

use App\TodoApp\Todo\UseCase\TodoUseCase;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Request $request, TodoUseCase $use_case)
    {
        $use_case->delete($request->id);
        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Todo\UseCase\TodoUseCase;

class IssueImportController extends Controller
{
    public function __invoke(TodoUseCase $use_case)
    {
        $use_case->issueImport();
        return redirect()->route('home');
    }
}

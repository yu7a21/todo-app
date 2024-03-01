<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\TodoApp\Exception\CategoryNotFoundException;
use App\TodoApp\Todo\UseCase\TodoUseCase;

class CategoryHomeController extends Controller
{
    public function __invoke(string $category_name, TodoUseCase $use_case)
    {
        try {
            $datas = $use_case->home($category_name);
        } catch (CategoryNotFoundException $e) {
            return redirect()->route("home");
        }

        return view("home", ["title"=>"Home | ".$category_name, "datas" => $datas]);
    }
}

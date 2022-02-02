<?php

namespace App\TodoApp\Todo\UseCase;

use App\TodoApp\Category\Infrastructure\CategoryRepositoryInterface;
use App\TodoApp\Todo\Domain\TodoDTOList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;

class TodoUseCase
{
    private CategoryRepositoryInterface $category_repository;
    private TodoRepositoryInterface $todo_repository;

    public function __construct()
    {
        $this->category_repository = app()->make(CategoryRepositoryInterface::class);
        $this->todo_repository = app()->make(TodoRepositoryInterface::class);
    }

    public function home(string $category_name = ""): TodoDTOList
    {
        //カテゴリ名からカテゴリentity取得
        $category = $this->category_repository->getByName($category_name);

        //カテゴリからタスクデータ取得
        $todo_list = $this->todo_repository->getByCategory($category);

        //EntityからDTOにつめかえ
        $todo_dto_list = new TodoDTOList($todo_list);

        //DTOのリストを返す
        return $todo_dto_list;
    }
}

<?php

namespace App\TodoApp\Todo\UseCase;

use App\TodoApp\Category\UseCase\CategoryUseCase;
use App\TodoApp\Todo\Domain\TodoDTO;
use App\TodoApp\Todo\Domain\TodoDTOList;
use App\TodoApp\Todo\Domain\TodoScale;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;

class TodoUseCase
{
    private TodoRepositoryInterface $todo_repository;

    public function __construct()
    {
        $this->todo_repository = app()->make(TodoRepositoryInterface::class);
        $this->category_use_case = new CategoryUseCase();
    }

    public function home(string $category_name = ""): array
    {
        //カテゴリ名からタスク一覧を取得
        $todo_dto_list = $this->findTodoListByCategoryName($category_name);

        //全カテゴリ取得
        $category_dto_list = $this->category_use_case->findAll();

        return [
            "todo_dto_list" => $todo_dto_list,
            "category_dto_list" => $category_dto_list,
            "scale_list" => TodoScale::getAllValue()
        ];
    }

    private function findTodoListByCategoryName(string $category_name = ""): TodoDTOList
    {
        //カテゴリ名からカテゴリentity取得
        $category = $this->category_use_case->findByName($category_name);

        //カテゴリからタスクデータ取得
        $todo_list = $this->todo_repository->getByCategory($category);

        //EntityからDTOにつめかえ
        $todo_dto_array = [];
        foreach ($todo_list->toArray() as $todo) {
            $todo_dto_array[] = new TodoDTO($todo);
        }

        $todo_dto_list = new TodoDTOList($todo_dto_array);

        //DTOのリストを返す
        return $todo_dto_list;
    }
}

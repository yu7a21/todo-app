<?php

namespace App\TodoApp\Todo\Infrastructure\Interface;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Domain\TodoCreateForm;

interface TodoRepositoryInterface
{
    /**
     * カテゴリでタスクを絞り込んで取得
     * nullを渡した場合or引数を渡さなかった場合全件取得する
     *
     * @param  mixed $category
     * @return TodoList
     */
    public function getByCategory(?Category $category = null): ?TodoList;

    /**
     * ドメインを永続化
     *
     * @param  Todo $todo
     * @return void
     */
    public function create(TodoCreateForm $todo): void;

    /**
     * タスクを削除（論理削除）
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * 削除されたタスクを取得
     *
     * @return TodoList
     */
    public function getDeletedTodo(): ?TodoList;
}

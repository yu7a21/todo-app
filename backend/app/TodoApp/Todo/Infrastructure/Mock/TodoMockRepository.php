<?php

namespace App\TodoApp\Todo\Infrastructure\Mock;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoCreateForm;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;

class TodoMockRepository implements TodoRepositoryInterface
{
    public function getByCategory(?Category $category = null): ?TodoList
    {
        return new TodoList([new Todo([])]);
    }

        /**
     * ドメインを永続化
     *
     * @param  Todo $todo
     * @return void
     */
    public function create(TodoCreateForm $todo): void
    {

    }

    /**
     * タスクを削除（論理削除）
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteById(int $id): void
    {

    }

    /**
     * タスクを完了にする（論理削除）
     *
     * @param  mixed $id
     * @return void
     */
    public function completeById(int $id): void
    {

    }

    /**
     * 削除されたタスクを取得
     *
     * @return TodoList
     */
    public function getDeletedTodo(): ?TodoList
    {
        return new TodoList([]);
    }

    /**
     * 削除されたタスクを取得
     *
     * @return TodoList
     */
    public function getCompletedTodo(): ?TodoList
    {
        return new TodoList([]);
    }
}

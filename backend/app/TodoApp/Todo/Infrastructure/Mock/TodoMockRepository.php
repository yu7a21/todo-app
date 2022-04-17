<?php

namespace App\TodoApp\Todo\Infrastructure\Mock;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoCreateForm;
use App\TodoApp\Todo\Domain\TodoUpdateForm;
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
     * 更新の保存
     *
     * @param  TodoUpdateForm $todo
     * @return void
     */
    public function updateByForm(TodoUpdateForm $todo): void
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
     * 完了したタスクを取得
     * 引数に配列を渡した場合その範囲の日付で完了になったタスクを検索する
     *
     * @return TodoList
     */
    public function getCompletedTodo(array $range = []): ?TodoList
    {
        return new TodoList([]);
    }

    /**
     * 渡されたカテゴリIDを持つタスクデータのカテゴリIDを削除
     *
     * @param  mixed $category_id
     * @return void
     */
    public function deleteCategoryId(int $category_id): void
    {

    }

    /**
     * Redmineからチケットをインポート
     *
     * @return void
     */
    public function importFromRedmine(): void
    {

    }

    /**
     * Backlogからチケットをインポート
     *
     * @return void
     */
    public function importFromBacklog(): void
    {

    }
}

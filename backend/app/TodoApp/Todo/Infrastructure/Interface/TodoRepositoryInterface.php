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
     * タスクを完了にする（論理削除）
     *
     * @param  mixed $id
     * @return void
     */
    public function completeById(int $id): void;

    /**
     * 削除されたタスクを取得
     *
     * @return TodoList
     */
    public function getDeletedTodo(): ?TodoList;

    /**
     * 完了したタスクを取得
     * 引数に配列を渡した場合その範囲の日付で完了になったタスクを検索する
     *
     * @return TodoList
     */
    public function getCompletedTodo(array $range = []): ?TodoList;


    /**
     * 渡されたカテゴリIDを持つタスクデータのカテゴリIDを削除
     *
     * @param  mixed $category_id
     * @return void
     */
    public function deleteCategoryId(int $category_id): void;
}

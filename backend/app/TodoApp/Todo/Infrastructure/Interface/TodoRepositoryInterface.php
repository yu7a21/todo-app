<?php

namespace App\TodoApp\Todo\Infrastructure\Interface;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\TodoList;

interface TodoRepositoryInterface
{
    /**
     * カテゴリでタスクを絞り込んで取得
     * nullを渡した場合or引数を渡さなかった場合全件取得する
     *
     * @param  mixed $category
     * @return TodoList
     */
    public function getByCategory(Category $category = null): TodoList;
}

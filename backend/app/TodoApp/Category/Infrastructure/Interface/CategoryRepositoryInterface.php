<?php

namespace App\TodoApp\Category\Infrastructure;

use App\TodoApp\Category\Domain\Category;

interface CategoryRepositoryInterface
{
    /**
     * カテゴリ名からカテゴリを取得
     * category_nameが空だった場合nullを返す
     *
     * @param  mixed $category_name
     * @return Category
     */
    public function getByName(string $category_name): ?Category;
}

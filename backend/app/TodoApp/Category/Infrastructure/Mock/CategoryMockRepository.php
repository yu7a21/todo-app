<?php

namespace App\TodoApp\Category\Infrastructure\Mock;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Category\Domain\CategoryForm;
use App\TodoApp\Category\Infrastructure\Interface\CategoryRepositoryInterface;

class CategoryMockRepository implements CategoryRepositoryInterface
{
    public function findByName(string $category_name): ?Category
    {
        return null;
    }

    public function findAll(): array
    {
        return [];
    }

    /**
     * カテゴリ作成
     *
     * @param  CategoryForm $category_form
     * @return void
     */
    public function create(CategoryForm $category_form): void
    {

    }

    /**
     * カテゴリ更新
     *
     * @param  CategoryForm $category_form
     * @return void
     */
    public function update(CategoryForm $category_form): void
    {

    }
}

<?php

namespace App\TodoApp\Category\Infrastructure\Interface;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Category\Domain\CategoryForm;

interface CategoryRepositoryInterface
{
    /**
     * カテゴリ名からカテゴリを取得
     * category_nameが空だった場合nullを返す
     *
     * @param  mixed $category_name
     * @return Category
     */
    public function findByName(string $category_name): ?Category;

    /**
     * 全カテゴリ取得
     *
     * @return Category[]
     */
    public function findAll(): array;

    /**
     * カテゴリ作成
     *
     * @param  CategoryForm $category_form
     * @return void
     */
    public function create(CategoryForm $category_form): void;

    /**
     * カテゴリ更新
     *
     * @param  CategoryForm $category_form
     * @return void
     */
    public function updateCategory(CategoryForm $category_form): void;

    /**
     * カテゴリを削除する
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteById(int $id): void;
}

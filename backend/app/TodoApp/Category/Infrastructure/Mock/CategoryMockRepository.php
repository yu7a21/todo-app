<?php

namespace App\TodoApp\Category\Infrastructure\Mock;

use App\TodoApp\Category\Domain\Category;
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
}

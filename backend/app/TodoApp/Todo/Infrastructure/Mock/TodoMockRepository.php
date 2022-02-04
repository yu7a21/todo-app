<?php

namespace App\TodoApp\Todo\Infrastructure\Mock;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;

class TodoMockRepository implements TodoRepositoryInterface
{
    public function getByCategory(?Category $category = null): ?TodoList
    {
        return new TodoList([new Todo([])]);
    }
}

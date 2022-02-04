<?php

namespace App\TodoApp\Category\UseCase;

use App\TodoApp\Category\Infrastructure\Interface\CategoryRepositoryInterface;
use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Category\Domain\CategoryDTO;
use App\TodoApp\Category\Domain\CategoryDTOList;

class CategoryUseCase
{
    public function __construct()
    {
        $this->category_repository = app()->make(CategoryRepositoryInterface::class);
    }

    public function findAll(): CategoryDTOList
    {
        $category_array = $this->category_repository->findAll();
        $category_dto = [];
        foreach ($category_array as  $category) {
            $category_dto[] = new CategoryDTO($category);
        }

        return new CategoryDTOList($category_dto);
    }

    public function findByName(string $category_name = ""): ?Category
    {
        return $this->category_repository->findByName($category_name);
    }
}

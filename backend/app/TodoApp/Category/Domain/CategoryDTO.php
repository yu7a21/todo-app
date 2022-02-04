<?php

namespace App\TodoApp\Category\Domain;

class CategoryDTO
{
    private int $id;
    private string $name;

    public function __construct(Category $category)
    {
        $this->id = $category->getId();
        $this->name = $category->getName();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

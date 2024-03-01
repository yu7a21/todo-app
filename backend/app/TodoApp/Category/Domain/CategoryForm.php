<?php

namespace App\TodoApp\Category\Domain;

class CategoryForm
{
    private ?int $id;
    private ?string $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasNotId(): bool
    {
        return is_null($this->id);
    }

    public function hasNotName(): bool
    {
        return is_null($this->name);
    }
}

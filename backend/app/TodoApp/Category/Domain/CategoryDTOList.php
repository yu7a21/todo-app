<?php

namespace App\TodoApp\Category\Domain;

class CategoryDTOList
{
    private array $category_dto_list = [];

    public function __construct(array $category_dto_array)
    {
        foreach ($category_dto_array as $category_dto) {
            //CategoryDTOのみもつ
            if ($category_dto instanceof CategoryDTO) {
                $this->category_dto_list[] = $category_dto;
            }
        }
    }

    public function getList(): array
    {
        return $this->category_dto_list;
    }
}

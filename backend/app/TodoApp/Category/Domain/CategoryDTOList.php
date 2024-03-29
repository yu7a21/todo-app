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

    /**
     * 全カテゴリを返す
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->category_dto_list;
    }

    /**
     * IDで検索
     *
     * @param  mixed $category_id
     * @return CategoryDTO
     */
    public function getById(int $category_id): CategoryDTO
    {
        foreach ($this->category_dto_list as $category_dto) {
            if ($category_dto->getId() == $category_id) {
                return $category_dto;
            }
        }
    }
}

<?php

namespace App\TodoApp\Todo\Domain;

class TodoDTOList
{
    private array $todo_dto_list = [];

    public function __construct(array $todo_dto_array)
    {
        foreach ($todo_dto_array as $todo_dto) {
            //TodoEntityのみもつ
            if ($todo_dto instanceof TodoDTO) {
                $this->todo_dto_list[] = $todo_dto;
            }
        }
    }

    public function getList(): array
    {
        return $this->todo_dto_list;
    }
}

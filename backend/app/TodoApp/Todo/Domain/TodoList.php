<?php

namespace App\TodoApp\Todo\Domain;

use App\TodoApp\Todo\Domain\Todo;

class TodoList
{
    private array $todo_list;

    public function __construct(array $todo_array)
    {
        //TODO: 色々チェック

        foreach ($todo_array as $todo) {
            //TodoEntityのみもつ
            if ( $todo instanceof Todo) {
                $this->todo_list[] = $todo;
            }
        }
    }

    public function toArray(): array
    {
        return $this->todo_list;
    }
}

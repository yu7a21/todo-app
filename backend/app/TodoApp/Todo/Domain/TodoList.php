<?php

namespace App\TodoApp\Todo\Domain;

use App\TodoApp\Todo\Domain\Todo;

class TodoList
{
    private array $todo_list;

    public function __construct(array $todo_list)
    {
        //TODO: 色々チェック

        foreach ($todo_list as $todo) {
            //TodoEntityのみもつ
            if ( $todo instanceof Todo) {
                $this->todo_list[] = $todo;
            }
        }
    }
}

<?php

namespace App\TodoApp\Todo\Domain;

class TodoDTOList
{
    private array $todo_dto = [];

    public function __construct(TodoList $todo_list)
    {
        foreach ($todo_list as $todo) {
            $this->todo_dto[] = new TodoDTO($todo);
        }
    }
}

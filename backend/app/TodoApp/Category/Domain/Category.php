<?php

namespace App\TodoApp\Category\Domain;

use DateTime;

class Category
{
    private int $id;
    private string $name;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->created_at = new Datetime($data["created_at"]);
        $this->updated_at = new DateTime($data["updated_at"]);
    }
}

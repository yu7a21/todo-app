<?php

namespace App\TodoApp\Todo\Domain;

use Illuminate\Http\Request;

class TodoUpdateForm
{
    //ID
    private int $id;
    //タイトル
    private string $title;
    //内容
    private string $description;
    //期日
    private string $deadline;
    //カテゴリID
    private string $category_id;
    //規模
    private TodoScale $scale;
    //状態
    private TodoStatus $status;

    public function __construct(array $request)
    {
        $this->id = $request["id"];
        $this->title = $request["title"];
        $this->description = $this->setNullableValue($request["description"]);
        $this->deadline = $this->setNullableValue($request["deadline"]);
        $this->category_id = $this->setNullableValue($request["category_id"]);
        $this->scale = new TodoScale($this->setNullableValue($request["scale"]));
        //TODO: statusが変更されるようになったら更新するようにする
        // $this->status = new TodoStatus(TodoStatus::NEW);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDeadline(): string
    {
        return $this->deadline;
    }

    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    public function getScale(): TodoScale
    {
        return $this->scale;
    }

    // public function getStatus(): TodoStatus
    // {
    //     return $this->status;
    // }

    private function setNullableValue(?string $value): string
    {
        return $value ? $value : "";
    }
}


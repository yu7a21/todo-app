<?php

namespace App\TodoApp\Todo\Domain;

class Todo
{
    //ID
    private int $id;
    //タイトル
    private string $title;
    //内容
    private string $description;
    //期日
    private string $deadline;
    //作成元(オリジナルorRedmineorBacklog)
    private string $origin;
    //元チケットID($origin=RedmineorBacklogのときのみ)
    private string $ticket_id;
    //カテゴリID
    private string $category_id;
    //規模
    private TodoScale $scale;
    //状態
    private string $status;
    //完了日
    private string $completed_at;
    //作成日
    private string $created_at;
    //更新日
    private string $updated_at;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->description = $this->setNullableValue($data["description"]);
        $this->deadline = $this->setNullableValue($data["deadline"]);
        $this->origin = $this->setNullableValue($data["origin"]);
        $this->ticket_id = $this->setNullableValue($data["ticket_id"]);
        $this->category_id = $this->setNullableValue($data["category_id"]);
        $this->scale = new TodoScale($this->setNullableValue($data["scale"]));
        $this->status = $this->setNullableValue($data["status"]);
        $this->completed_at = $this->setNullableValue($data["completed_at"]);
        $this->created_at = $data["created_at"];
        $this->updated_at = $data["updated_at"];
    }

    public function getId(): string
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

    public function getDeadLine(): string
    {
        return $this->deadline;
    }

    public function getOrgin(): string
    {
        return $this->origin;
    }

    public function getTicketId(): string
    {
        return $this->ticket_id;
    }

    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    public function getScale(): TodoScale
    {
        return $this->scale;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCompletedAt(): string
    {
        return $this->completed_at;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    private function setNullableValue(?string $value): string
    {
        return $value ? $value : "";
    }
}

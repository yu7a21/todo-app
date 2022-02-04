<?php

namespace App\TodoApp\Todo\Domain;

class TodoDTO
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
    private string $scale;
    //状態
    private string $status;
    //完了日
    private string $completed_at;
    //作成日
    private string $created_at;
    //更新日
    private string $updated_at;

    public function __construct(Todo $todo)
    {
        $this->id = $todo->getId();
        $this->title = $todo->getTitle();
        $this->description = $todo->getDescription();
        $this->deadline = $todo->getDeadLine();
        $this->origin = $todo->getOrgin();
        $this->ticket_id = $todo->getTicketId();
        $this->category_id = $todo->getCategoryId();
        $this->scale = $todo->getScale();
        $this->status = $todo->getStatus();
        $this->completed_at = $todo->getCompletedAt();
        $this->created_at = $todo->getCreatedAt();
        $this->updated_at = $todo->getUpdatedAt();
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

    public function getScale(): string
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
}

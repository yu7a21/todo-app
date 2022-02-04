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
    private string $scale;
    //状態
    private string $status;
    //完了日
    private string $completion_at;
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
        $this->scale = $this->setNullableValue($data["scale"]);
        $this->status = $this->setNullableValue($data["status"]);
        $this->completion_at = $this->setNullableValue($data["completion_at"]);
        $this->created_at = $data["created_at"];
        $this->updated_at = $data["updated_at"];
    }

    private function setNullableValue(?string $value): string
    {
        return $value ? $value : "";
    }
}

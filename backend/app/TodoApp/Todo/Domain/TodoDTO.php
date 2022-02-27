<?php

namespace App\TodoApp\Todo\Domain;

use DateTime;
use Illuminate\Support\Facades\Date;

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
    private TodoOrigin $origin;
    //元チケットID($origin=RedmineorBacklogのときのみ)
    private string $ticket_id;
    //カテゴリID
    private string $category_id;
    //規模
    private TodoScale $scale;
    //状態
    private TodoStatus $status;
    //完了日
    private string $completed_at;
    //削除フラグ
    private bool $is_deleted;
    //作成日
    private string $created_at;
    //更新日
    private string $updated_at;

    //表示時のカラーコード（規模、期限までの長さで算出）
    private string $color_code;

    //redmine,backlogへのリンク
    private string $ticket_link;

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
        $this->is_deleted = $todo->isDeleted();
        $this->created_at = $todo->getCreatedAt();
        $this->updated_at = $todo->getUpdatedAt();

        $this->color_code = $this->setColorCode();
        $this->setTicketLink();
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
        //Y-m-d H:i:s で入っているが画面では邪魔なのでフォーマットして返す
        if ($this->deadline == "") {
            return "";
        } else {
            $date = new DateTime($this->deadline);
            return $date->format('Y/m/d');
        }
    }

    public function getOrigin(): TodoOrigin
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

    public function getStatus(): TodoStatus
    {
        return $this->status;
    }

    public function getCompletedAt(): string
    {
        return $this->completed_at;
    }

    public function isDeleted(): bool
    {
        return $this->is_deleted;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getColorCode(): string
    {
        return $this->color_code;
    }

    public function getTicketLink(): string
    {
        return $this->ticket_link;
    }

    /**
     * 期限を過ぎているかどうかを返す
     *
     * @return bool
     */
    public function isOutOfDeadline(): bool
    {
        $now = new DateTime();
        return strtotime($now->format('Y/m/d')) > strtotime($this->deadline);
    }

    /**
     * 期日・規模から優先度を算出し、このタスクを表示するときに使うカラーコードを返す
     *
     * @return string
     */
    private function setColorCode(): string
    {
        //規模をレベルに変換
        $scale_level = 0;
        switch ($this->scale->getScale()) {
            case TodoScale::LARGE:
                $scale_level = 1;
                break;
            case TodoScale::MIDIUM:
                $scale_level = 2;
                break;
            case TodoScale::SMALL:
                $scale_level = 3;
                break;
            default:
                break;
        }

        //今日から期日までの期間を3段階のレベルに変換
        $deadline_level = 0;
        $now = new DateTime();
        $deadline_time = new DateTime($this->deadline);
        $diff = $deadline_time->diff($now);
        if ($diff->d < 4) {
            $deadline_level = 3;
        } else if ($diff->d < 8) {
            $deadline_level = 2;
        } else {
            $deadline_level = 1;
        }

        //規模と期日のレベルの合計値で優先度を算出、カラーコードを返す
        /*
        合計値6:high
        合計値5:middle_high
        合計値4:middle
        合計値3:middle_low
        合計値2:low
        */
        switch($scale_level + $deadline_level) {
            case 6:
                return TodoColorCodeEnum::COLOR_CODE_LIST[TodoColorCodeEnum::HIGH];
            case 5:
                return TodoColorCodeEnum::COLOR_CODE_LIST[TodoColorCodeEnum::MIDDLE_HIGH];
            case 4:
                return TodoColorCodeEnum::COLOR_CODE_LIST[TodoColorCodeEnum::MIDDLE];
            case 3:
                return TodoColorCodeEnum::COLOR_CODE_LIST[TodoColorCodeEnum::MIDDLE_LOW];
            case 2:
                return TodoColorCodeEnum::COLOR_CODE_LIST[TodoColorCodeEnum::LOW];
            default:
                return TodoColorCodeEnum::COLOR_CODE_LIST[TodoColorCodeEnum::LOW];
        }

    }

    private function setTicketLink(): void
    {
        if ($this->origin->isBacklog()) {
            $this->ticket_link = "https://team-lab.backlog.com/view/". $this->ticket_id;
        } else if ($this->origin->isRedmine()) {
            $this->ticket_link = "https://mori-building-redmine.team-lab.dev/issues/". $this->ticket_id;
        }
    }
}

<?php

namespace App\TodoApp\Todo\Domain;

class TodoStatus
{
    public const NEW = "new";
    public const NEW_JA = "新規";
    public const IN_PROGRESS = "in progress";
    public const IN_PROGRESS_JA = "進行中";
    public const DONE = "done";
    public const DONE_JA = "終了";

    private string $status;

    public function __construct(string $status)
    {
        $this->status = $this->checkStatusValue($status);
    }

    /**
     * この値オブジェクトが持てる値かをチェックし、持てない値だった場合は空文字を入れる。
     *
     * @param  string $scale
     * @return string
     */
    private function checkStatusValue(string $status): string
    {
        if (array_key_exists($status, self::getAllValue())) {
            return $status;
        } else {
            return "";
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function getAllValue(): array
    {
        return [
            self::NEW => self::NEW_JA,
            self::IN_PROGRESS => self::IN_PROGRESS_JA,
            self::DONE => self::DONE_JA
        ];
    }
}

<?php

namespace App\TodoApp\Todo\Domain;

class TodoColorCodeEnum
{
    //優先度
    public const HIGH = "high";
    public const MIDDLE_HIGH = "middle_high";
    public const MIDDLE = "middle";
    public const MIDDLE_LOW = "middle_low";
    public const LOW = "low";

    //優先度ごとのカラーコードリスト
    public const COLOR_CODE_LIST = [
        self::HIGH => "#FFB000",
        self::MIDDLE_HIGH => "#FFD066",
        self::MIDDLE => "#FFE099",
        self::MIDDLE_LOW => "#FFECC2",
        self::LOW => "#FFF9EB"
    ];
}

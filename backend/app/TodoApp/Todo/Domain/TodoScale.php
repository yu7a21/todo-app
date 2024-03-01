<?php

namespace App\TodoApp\Todo\Domain;

class TodoScale
{
    public const LARGE = "large";
    public const LARGE_JA = "大";
    public const MIDIUM = "midium";
    public const MIDIUM_JA = "中";
    public const SMALL = "small";
    public const SMALL_JA = "小";

    private string $scale;

    public function __construct(string $scale)
    {
        $this->scale = $this->checkScaleValue($scale);
    }

    /**
     * この値オブジェクトが持てる値かをチェックし、持てない値だった場合は空文字を入れる。
     *
     * @param  string $scale
     * @return string
     */
    private function checkScaleValue(string $scale): string
    {
        if (array_key_exists($scale, self::getAllValue())) {
            return $scale;
        } else {
            return "";
        }
    }

    public function getScale(): string
    {
        return $this->scale;
    }

    public static function getAllValue(): array
    {
        return [
            self::LARGE => self::LARGE_JA,
            self::MIDIUM => self::MIDIUM_JA,
            self::SMALL => self::SMALL_JA
        ];
    }
}

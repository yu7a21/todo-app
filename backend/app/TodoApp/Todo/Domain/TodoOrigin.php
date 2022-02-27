<?php

namespace App\TodoApp\Todo\Domain;

class TodoOrigin
{
    public const ORIGINAL = "original";
    public const BACKLOG = "backlog";
    public const REDMINE = "redmine";

    private string $origin;

    public function __construct(string $origin)
    {
        $this->origin = $origin;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }
}

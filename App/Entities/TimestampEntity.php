<?php

namespace App\Entities;

class TimestampEntity
{
    private $creationTime;

    public function __construct()
    {
        $this->creationTime = new \DateTimeImmutable();
    }

    public function getCreationTime(): \DateTimeImmutable
    {
        return $this->creationTime;
    }
}

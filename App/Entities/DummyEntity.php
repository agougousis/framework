<?php

namespace App\Entities;

class DummyEntity
{
    private $dummyString;

    public function __construct()
    {
        $this->dummyString = 'Hello world!';
    }

    public function getDummyString(): string
    {
        return $this->dummyString;
    }
}

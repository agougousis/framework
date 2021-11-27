<?php

namespace App\Entities;

class ValidationResult
{
    private $isValid;

    private $errorMessage;

    public function __construct($isValid, $errorMessage = '')
    {
        $this->isValid = $isValid;
        $this->errorMessage = $errorMessage;
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}

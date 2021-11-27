<?php

namespace App\Validators;

use App\Entities\ValidationResult;

class SmsMessageValidator
{
    /**
     * @param $requestBody This is the request body after it has been JSON-decoded
     *
     * @return ValidationResult
     */
    public static function validateRequestData($requestBody) : ValidationResult
    {
        if (!is_array($requestBody)) {
            return new ValidationResult(false, 'Invalid data structure!');
        }

        if (!self::validateRecipient($requestBody)) {
            return new ValidationResult(false, 'Recipient field is missing or invalid!');
        }

        if (!self::validateOriginator($requestBody)) {
            return new ValidationResult(false, 'Originator field is missing or invalid!');
        }

        if (!self::validateMessage($requestBody)) {
            return new ValidationResult(false, 'Message field is missing or invalid!');
        }

        return new ValidationResult(true);
    }

    private static function validateRecipient($requestBody) : bool
    {
        if (empty($requestBody['recipient'])) {
            return false;
        }

        if (!self::isValidRecipient($requestBody['recipient'])) {
            return false;
        }

        return true;
    }

    private static function validateOriginator($requestBody) : bool
    {
        if (empty($requestBody['originator'])) {
            return false;
        }

        if (!self::isValidOriginator($requestBody['originator'])) {
            return false;
        }

        return true;
    }

    private static function validateMessage($requestBody) : bool
    {
        if (empty($requestBody['message'])) {
            return false;
        }

        if (!is_string($requestBody['message'])) {
            return false;
        }

        return true;
    }

    private static function isValidRecipient($value) : bool
    {
        if (preg_match('/[0-9]{1,11}/', $value) == false) {
            return false;
        }

        return true;
    }

    private static function isValidOriginator($value)
    {
        if (!is_string($value)) {
            return false;
        }

        if (preg_match('/[a-zA-Z0-9]{1,11}/', $value) == false) {
            return false;
        }

        return true;
    }
}

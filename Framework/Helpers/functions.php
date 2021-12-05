<?php

use Bespoke\Components\Container;

/**
 * Define an alternative implementation of getallheaders, in case we are not using Apache.
 */
if (!function_exists('getallheaders'))
{
    function getallheaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_')
            {
                $curatedName = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$curatedName] = $value;
            }
        }
        return $headers;
    }
}

function container() {
    return Container::getInstance();
}

<?php

return [
    'mappings' => [
        'Bespoke\Http\Request'    => 'Bespoke\ServiceProviders\RequestProvider',
        'Psr\Log\LoggerInterface' => 'Bespoke\ServiceProviders\FileLoggerProvider',

    ],
    'aliases'  => [
        'request' => 'Bespoke\Http\Request',
        'logger'  => 'Psr\Log\LoggerInterface',
    ]
];

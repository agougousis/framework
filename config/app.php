<?php

return [
    'loggers'  => [
        'file'    => [
            'directory' => ROOT_PATH . '/logs'
        ],
        'monolog' => [
            'target'    => 'file', // 'syslog' , 'file'
            'directory' => ROOT_PATH . '/logs'
        ]
    ],
    'services' => [
        'mappings' => [
            'Psr\Log\LoggerInterface' => 'App\ServiceProviders\MonologProvider',
        ],
        'aliases'  => [
            'logger' => 'Psr\Log\LoggerInterface',
        ]
    ],

];

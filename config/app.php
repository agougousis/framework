<?php

return [
    'loggers' => [
        'file' => [
            'directory' => ROOT_PATH . '/logs'
        ],
        'monolog' => [
            'target' => 'file', // 'syslog' , 'file'
            'directory' => ROOT_PATH . '/logs'
        ]
    ]
];

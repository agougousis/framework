<?php

return [
    'loggers' => [
        'file' => [
            'directory' => ROOT_PATH . '/logs'
        ],
        'monolog' => [
            'target' => 'syslog'
        ]
    ]
];

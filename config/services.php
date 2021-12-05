<?php

return [
    'Bespoke\Http\Request'    => 'Bespoke\ServiceProviders\RequestProvider',
    'request'                 => 'Bespoke\ServiceProviders\RequestProvider',
    'Psr\Log\LoggerInterface' => 'Bespoke\ServiceProviders\FileLoggerProvider',
    'logger'                  => 'Bespoke\ServiceProviders\FileLoggerProvider',
];

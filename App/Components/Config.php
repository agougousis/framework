<?php

namespace App\Components;

use DirectoryIterator;

class Config
{
    private static $configuration = [];

    public static function loadConfigurationFiles()
    {
        $dirIterator = new DirectoryIterator(CONFIG_PATH);

        foreach ($dirIterator as $fileinfo) {
            if ($fileinfo->getExtension() == 'php') {
                $configValues = require CONFIG_PATH.'/'.$fileinfo->getFilename();
                self::$configuration = array_merge(self::$configuration, $configValues);
            }
        }
    }

    public static function get(string $configKey)
    {
        if (key_exists($configKey, self::$configuration)) {
            return self::$configuration[$configKey];
        }

        throw new \Exception('Uknown configuration key!');
    }

    public static function getAll() : array
    {
        return self::$configuration;
    }
}


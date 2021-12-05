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
                $filename = $fileinfo->getFilename();
                $filenameWithoutExtension = basename($filename, '.php');
                $configValues = require CONFIG_PATH.'/'.$filename;

                self::$configuration[$filenameWithoutExtension] = $configValues;
            }
        }
    }

    public static function get(string $configKey)
    {
        $tempResult = self::$configuration;

        $keyParts = explode('.', $configKey);
        foreach($keyParts as $keyPart) {
            if (!array_key_exists($keyPart, $tempResult)) {
                throw new \Exception('Uknown configuration key >'. $configKey . '<');
            }

            $tempResult = $tempResult[$keyPart];
        }

        return $tempResult;
    }

    public static function getAll() : array
    {
        return self::$configuration;
    }
}


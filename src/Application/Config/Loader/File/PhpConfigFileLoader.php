<?php

namespace Mateusz\Mercetree\Application\Config\Loader\File;

class PhpConfigFileLoader implements PhpConfigFileLoaderInterface
{
    /**
     * @throws ConfigFileException
     */
    public function load(string $pathname) : array
    {
        if (! $pathname) {
            throw ConfigFileException::createInvalidPathname($pathname);
        }

        if (! is_file($pathname)) {
            throw ConfigFileException::createNotFound($pathname);
        }

        if (! is_readable($pathname)) {
            throw ConfigFileException::createNotReadable($pathname);
        }

        $sandbox = function($__pathname) {
            return require $__pathname;
        };

        $config = $sandbox($pathname);

        if (! is_array($config)) {
            throw ConfigFileException::createNotArray($pathname, $config);
        }

        return $config;
    }
}

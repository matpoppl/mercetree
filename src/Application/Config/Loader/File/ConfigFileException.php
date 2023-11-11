<?php

namespace Mateusz\Mercetree\Application\Config\Loader\File;

class ConfigFileException extends \Exception
{
    public static function createInvalidPathname(string $pathname) : static
    {
        return new static("Invalid config file  pathname `{$pathname}`");
    }

    public static function createNotFound(string $pathname) : static
    {
        return new static("Config file `{$pathname}` don't exists");
    }

    public static function createNotReadable(string $pathname) : static
    {
        return new static("Config file `{$pathname}` is not readable");
    }

    public static function createNotArray(string $pathname, mixed $data) : static
    {
        $type = is_object($data) ? get_class($data) : gettype($data);
        return new static("Array required. Unsupported config type `{$type}` in file `{$pathname}`");
    }
}

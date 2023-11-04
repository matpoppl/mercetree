<?php

namespace Mateusz\Mercetree\ServiceManager\Config;

class InvalidTypeException extends \Exception
{
    public static function create(string $current, string $expected) : self
    {
        return new self("Invalid config entry type `{$current}` expecting `{$expected}`");
    }
}

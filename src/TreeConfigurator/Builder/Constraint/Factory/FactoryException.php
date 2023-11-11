<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

class FactoryException extends \UnexpectedValueException
{
    const CODE_DONT_EXISTS = 1;
    const CODE_MISSING_PARAMETER = 2;

    public static function classDontExists(string $className) : static
    {
        return new static("Class `{$className}` don't exists", self::CODE_DONT_EXISTS);
    }

    public static function missingParameter(string $className, string $paramName) : static
    {
        return new static("Missing constructor `{$className}` parameter `{$paramName}`", self::CODE_MISSING_PARAMETER);
    }
}

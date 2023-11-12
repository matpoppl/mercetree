<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

class RowException extends \Exception implements RowExceptionInterface
{
    public static function dontExists(string $rowId) : static
    {
        return new static("Row `{$rowId}` dont exists", self::CODE_DONT_EXISTS);
    }
}

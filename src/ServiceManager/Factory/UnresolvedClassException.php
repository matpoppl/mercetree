<?php

namespace Mateusz\Mercetree\ServiceManager\Factory;

class UnresolvedClassException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct("Class `{$type}` don't exists");
    }
}

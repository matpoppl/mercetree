<?php

namespace Mateusz\Mercetree\ServiceManager\Factory;

use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;

interface ClassResolverInterface
{

    /**
     * @param class-string $requestedName
     * @param class-string $expectedType
     * @return class-string
     * @throws UnresolvedClassException
     * @throws UnexpectedTypeException
     */
    public function resolve(string $requestedName, string $expectedType) : string;

    public function create(string $requestedName, string $expectedType) : object;
}

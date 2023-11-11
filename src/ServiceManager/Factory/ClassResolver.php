<?php

namespace Mateusz\Mercetree\ServiceManager\Factory;

class ClassResolver implements ClassResolverInterface
{

    /**
     * @template T
     * @param class-string<T> $requestedName
     * @param class-string $expectedType
     * @return T
     * @throws UnresolvedClassException
     * @throws UnexpectedTypeException
     */
    public function resolve(string $requestedName, string $expectedType) : string
    {
        if (! class_exists($requestedName)) {
            throw new UnresolvedClassException($requestedName);
        }

        if (! is_subclass_of($requestedName, $expectedType)) {
            throw new UnexpectedTypeException($requestedName, $expectedType);
        }

        return $requestedName;
    }

    /**
     * @template T
     * @param class-string<T> $requestedName
     * @param class-string $expectedType
     * @return object<T>
     * @throws UnresolvedClassException
     * @throws UnexpectedTypeException
     */
    public function create(string $requestedName, string $expectedType) : object
    {
        $className = $this->resolve($requestedName, $expectedType);
        return new $className();
    }
}

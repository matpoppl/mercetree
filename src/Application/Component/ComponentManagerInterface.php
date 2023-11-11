<?php

namespace Mateusz\Mercetree\Application\Component;

interface ComponentManagerInterface
{
    /**
     *
     * @template T of object
     * @param class-string<T> $id
     * @throws NotFoundExceptionInterface
     * @return object
     * @psalm-return T
     */
    public function get(string $id) : object;
}

<?php

namespace Mateusz\Mercetree\Application\Component;

use Psr\Container\ContainerInterface;

class MockComponentService
{
    public readonly string $foo;
    public function __construct(array $options)
    {
        $this->foo = $options['foo'] ?? '';
    }
}

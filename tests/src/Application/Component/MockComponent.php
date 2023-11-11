<?php

namespace Mateusz\Mercetree\Application\Component;

use Psr\Container\ContainerInterface;

class MockComponent
{
    public function __construct(public readonly ContainerInterface $container)
    {}
}

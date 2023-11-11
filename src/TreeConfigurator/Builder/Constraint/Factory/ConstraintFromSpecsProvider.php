<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Psr\Container\ContainerInterface;

class ConstraintFromSpecsProvider implements ConstraintFromSpecsProviderInterface
{
    private readonly ConstraintFactory $factory;

    public function __construct(private readonly ContainerInterface $container)
    {
        $this->factory = new ConstraintFactory();
    }

    public function __invoke(ConstraintSpecsInterface $specs) : ConstraintInterface
    {
        return ($this->factory)($this->container, $specs->getConstraintType(), $specs->getConstraintArgs());
    }
}

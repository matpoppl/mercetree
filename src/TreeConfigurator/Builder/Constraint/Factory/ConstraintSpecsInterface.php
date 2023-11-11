<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

interface ConstraintSpecsInterface
{
    /**
     * @return class-string
     */
    public function getConstraintType(): string;

    /**
     * @return array<string, mixed>
     */
    public function getConstraintArgs(): array;
}

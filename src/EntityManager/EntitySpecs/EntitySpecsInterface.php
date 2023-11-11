<?php

namespace Mateusz\Mercetree\EntityManager\EntitySpecs;

interface EntitySpecsInterface
{
    /**
     * @return class-string
     */
    public function getEntityType(): string;

    /**
     * @return class-string
     */
    public function getRepositoryType(): string;
}

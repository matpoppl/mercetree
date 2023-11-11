<?php

namespace Mateusz\Mercetree\EntityManager\EntitySpecs;

class EntitySpecs implements EntitySpecsInterface
{
    public function __construct(private readonly array $options)
    {
        if (! isset($options['entity_type'])) throw new \UnexpectedValueException('`entity_type` required');
        if (! isset($options['repository_type'])) throw new \UnexpectedValueException('`repository_type` type required');
    }

    public function getEntityType(): string
    {
        return $this->options['entity_type'];
    }

    public function getRepositoryType(): string
    {
        return $this->options['repository_type'];
    }
}

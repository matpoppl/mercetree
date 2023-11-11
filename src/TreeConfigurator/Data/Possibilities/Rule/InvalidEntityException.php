<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule;

class InvalidEntityException extends \Exception
{
    public function __construct(mixed $entity, string $expected)
    {
        $type = is_object($entity) ? get_class($entity) : gettype($entity);
        parent::__construct("Invalid entity type `{$type}`, expecting `{$expected}`");
    }
}

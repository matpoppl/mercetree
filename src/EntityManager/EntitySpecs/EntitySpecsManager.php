<?php

namespace Mateusz\Mercetree\EntityManager\EntitySpecs;

class EntitySpecsManager implements EntitySpecsManagerInterface
{
    /**
     * @var EntitySpecsInterface[]
     */
    private array $specs = [];

    /**
     * @var array<string,string>
     */
    private array $aliases = [];

    /**
     * @var array<string,array<string,mixed>>
     */
    private array $entities = [];

    public function __construct(array $options)
    {
        $this->aliases = $options['aliases'] ?? [];
        $entities = $options['entities'] ?? null;

        if (! $entities) throw new \UnexpectedValueException('`entities` required');

        $this->entities = $entities;
    }

    public function get(string $id): EntitySpecsInterface
    {
        while (array_key_exists($id, $this->aliases)) {
            $id = $this->aliases[$id];
        }

        if (array_key_exists($id, $this->specs)) {
            return $this->specs[$id];
        }

        $options = $this->entities[$id] ?? null;

        if (! $options) {
            throw new \UnexpectedValueException("Options for entity `{$id}` not found");
        }

        $options['entity_type'] ??= $id;

        $this->specs[$id] = new EntitySpecs($options);

        return $this->specs[$id];
    }
}

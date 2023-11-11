<?php

namespace Mateusz\Mercetree\EntityManager\Repository;

use Mateusz\Mercetree\Dbal\DbalManagerInterface;
use Mateusz\Mercetree\EntityManager\EntitySpecs\EntitySpecsManagerInterface;

class RepositoryManager implements RepositoryManagerInterface
{
    public function __construct(private readonly DbalManagerInterface $dbalManager, private readonly EntitySpecsManagerInterface $entitySpecsManager, private readonly array $options)
    {
    }

    public function get(string $entityType): RepositoryInterface
    {
        $specs = $this->entitySpecsManager->get($entityType);

        $className = $specs->getRepositoryType();

        if (! class_exists($className)) {
            throw new \UnexpectedValueException("Repository class `{$className}` don\'t exists");
        }

        $options = $this->options[$className] ?? [];
        $adapterId = $options['adapter'] ?? $className;

        return new $className( $this->dbalManager->get($adapterId), $options );
    }
}

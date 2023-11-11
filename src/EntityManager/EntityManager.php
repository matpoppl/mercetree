<?php

namespace Mateusz\Mercetree\EntityManager;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;

class EntityManager implements EntityManagerInterface
{
    public function __construct(private readonly RepositoryManagerInterface $repositoryManager)
    {
    }

    public function getRepository(string $entityType): RepositoryInterface
    {
        return $this->repositoryManager->get($entityType);
    }
}

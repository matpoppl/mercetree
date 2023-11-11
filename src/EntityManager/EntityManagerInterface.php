<?php

namespace Mateusz\Mercetree\EntityManager;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;

interface EntityManagerInterface
{
    public function getRepository(string $entityType) : RepositoryInterface;
}

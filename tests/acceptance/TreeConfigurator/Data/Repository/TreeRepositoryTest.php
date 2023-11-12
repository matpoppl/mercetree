<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;
use Mateusz\Mercetree\TestApplication;
use PHPUnit\Framework\TestCase;

class TreeRepositoryTest extends TestCase
{
    /**
     * @group TreeRepository
     */
    public function testFactory() : TreeRepositoryInterface
    {
        $app = TestApplication::getInstance();

        $reposManager = $app->getService(RepositoryManagerInterface::class);

        self::assertInstanceOf(RepositoryManagerInterface::class, $reposManager);

        $treeRepo = $reposManager->get(TreeRepositoryInterface::class);

        self::assertInstanceOf(TreeRepositoryInterface::class, $treeRepo);

        return $treeRepo;
    }

    /**
     * @depends testFactory
     * @group TreeRepository
     */
    public function testGetAll(TreeRepositoryInterface $repository)
    {
        $ids = [];
        foreach ($repository->getAll() as $entity) {
            $ids[] = $entity->getId();
        }

        sort($ids);

        self::assertEquals(['tree:big', 'tree:medium', 'tree:small'], $ids);
    }
}

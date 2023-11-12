<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;
use Mateusz\Mercetree\TestApplication;
use PHPUnit\Framework\TestCase;

class TreeDecorationTest extends TestCase
{
    /**
     * @group TreeDecorationRepository
     */
    public function testFactory() : TreeDecorationRepositoryInterface
    {
        $app = TestApplication::getInstance();

        $reposManager = $app->getService(RepositoryManagerInterface::class);

        self::assertInstanceOf(RepositoryManagerInterface::class, $reposManager);

        $treeRepo = $reposManager->get(TreeDecorationRepositoryInterface::class);

        self::assertInstanceOf(TreeDecorationRepositoryInterface::class, $treeRepo);

        return $treeRepo;
    }

    /**
     * @depends testFactory
     * @group TreeDecorationRepository
     */
    public function testGetAll(TreeDecorationRepositoryInterface $repository)
    {
        $ids = [];
        foreach ($repository->getAll() as $entity) {
            $ids[] = $entity->getId();
        }
        sort($ids);

        $treeDecorations = TestApplication::getInstance()->getTestConfig('tree-decorations');
        $treeDecorations = array_values($treeDecorations['ids']);
        $expected = array_merge(...$treeDecorations);
        sort($expected);

        self::assertEquals($expected, $ids);
    }
}

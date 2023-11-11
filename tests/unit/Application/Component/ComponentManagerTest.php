<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;

#[CoversClass(ComponentManager::class)]
class ComponentManagerTest extends TestCase
{

    /**
     * @throws NotFoundExceptionInterface
     */
    public function testNotFoundExceptionThrow()
    {
        self::expectException(NotFoundExceptionInterface::class);
        $componentManager = new ComponentManager(new ServiceManager());
        $componentManager->get('missing-service-name');
    }

    /**
     * @throws ContainerExceptionInterface
     */
    public function testFactory()
    {
        $factory = new ComponentManagerFactory();

        $componentManager = $factory(new ServiceManager(), ComponentManager::class, [
            'service_manager' => [
                'aliases' => [
                    'mock-service' => MockComponentService::class,
                ],
                'factories' => [
                    MockComponentService::class => MockComponentServiceFactory::class,
                ],
            ],

            MockComponentService::class => [
                'foo' => 'bar',
            ],
        ]);

        self::assertInstanceOf(ComponentManager::class, $componentManager);

        return $componentManager;
    }

    /**
     * @depends testFactory
     */
    public function testServiceLocator(ComponentManager $componentManager)
    {
        self::assertInstanceOf(MockComponentService::class, $componentManager->get('mock-service'));
    }
}

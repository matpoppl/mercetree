<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

#[CoversClass(ComponentManagerFactory::class)]
class ComponentManagerFactoryTest extends TestCase
{

    /**
     * @throws ContainerExceptionInterface
     */
    public function testInvokeConfigless()
    {
        $factory = new ComponentManagerFactory();

        $component = $factory(new ServiceManager(), MockComponent::class, [
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

        self::assertInstanceOf(MockComponent::class, $component);

        return $component;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @covers MockComponent
     * @depends testInvokeConfigless
     */
    public function testComponentContainer(MockComponent $component)
    {
        $service = $component->container->get('mock-service');

        self::assertInstanceOf(MockComponentService::class, $service);
        self::assertEquals('bar', $service->foo);
    }
}

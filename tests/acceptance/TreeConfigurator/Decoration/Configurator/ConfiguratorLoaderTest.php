<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Mateusz\Mercetree\TestApplication;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface;
use PHPUnit\Framework\TestCase;

class ConfiguratorLoaderTest extends TestCase
{
    /**
     * @group ConfiguratorLoader
     * @covers TestApplication::getComponent()
     * @covers \Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponent::getConfiguratorLoader()
     */
    public function testComponent() : ConfiguratorLoaderInterface
    {
        $component = TestApplication::getInstance()->getComponent(TreeConfiguratorComponentInterface::class);
        self::assertInstanceOf(TreeConfiguratorComponentInterface::class, $component);
        $configurator = $component->getConfiguratorLoader();
        self::assertInstanceOf(ConfiguratorLoaderInterface::class, $configurator);
        return $configurator;
    }

    /**
     * @group ConfiguratorLoader
     * @depends testComponent
     * @covers ConfiguratorLoader
     */
    public function testNotFound(ConfiguratorLoaderInterface $loader)
    {
        self::expectException(ConfiguratorLoaderExceptionInterface::class);
        $loader->load('missing');
    }
}

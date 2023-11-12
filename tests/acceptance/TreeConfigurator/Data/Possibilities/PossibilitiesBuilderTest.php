<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities;

use Mateusz\Mercetree\TestApplication;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface as Component;
use PHPUnit\Framework\TestCase;

class PossibilitiesBuilderTest extends TestCase
{
    /**
     * @group PossibilitiesBuilder
     */
    public function testFactory() : PossibilitiesBuilderInterface
    {
        $app = TestApplication::getInstance();

        $component = $app->getComponent(Component::class);

        self::assertInstanceOf(Component::class, $component);

        $builder = $component->getPossibilitiesBuilder();

        self::assertInstanceOf(PossibilitiesBuilderInterface::class, $builder);

        return $builder;
    }

    /**
     * @depends testFactory
     * @group PossibilitiesBuilder
     */
    public function testBuilder(PossibilitiesBuilderInterface $builder)
    {
        $knownValues = TestApplication::getInstance()->getTestConfig('tree-decorations');
        $knownValues = $knownValues['ids'];

        foreach ([
             'small' => [...$knownValues['small'], ...$knownValues['medium']],
             'medium' => [...$knownValues['small'], ...$knownValues['medium'], ...$knownValues['big']],
             'big' => [...$knownValues['small'], ...$knownValues['medium'], ...$knownValues['big']],
         ] as $size => $expected) {

            sort($expected);

            $symbols = $builder->getBySize($size);
            sort($symbols);

            self::assertNotEmpty($expected, 'Sanity check');
            self::assertNotEmpty($symbols, "Possibilities for size `{$size}` must exist");
            self::assertEquals($expected, $symbols);
        }
    }
}

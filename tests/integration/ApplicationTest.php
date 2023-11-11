<?php

namespace Mateusz\Mercetree;

use Mateusz\Mercetree\Shop\ShopComponentInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Mateusz\Mercetree\Application\Component\NotFoundExceptionInterface;

#[CoversClass(Application::class)]
#[CoversClass(TestApplication::class)]
class ApplicationTest extends TestCase
{
    /**
     * @covers TestApplication::getInstance
     * @covers Application::create
     */
    public function testFactory()
    {
        $app = TestApplication::getInstance()->getRealApplication();
        self::assertInstanceOf(Application::class, $app);
        return $app;
    }

    /**
     * @depends testFactory
     * @param Application $app
     * @return void
     */
    public function testExistingComponents(Application $app)
    {
        self::assertInstanceOf(ShopComponentInterface::class, $app->getComponent(ShopComponentInterface::class));
    }
    /**
     * @depends testFactory
     * @param Application $app
     * @return void
     */
    public function testMissingComponents(Application $app)
    {
        self::expectException(NotFoundExceptionInterface::class);
        $app->getComponent('missing-components-name');
    }
}

<?php
declare(strict_types=1);

namespace Mateusz\Mercetree\Shop;

use Mateusz\Mercetree\Application\Component\ComponentManager;
use Mateusz\Mercetree\Application\Component\ComponentManagerInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\Data\PresenterInterface;
use Mateusz\Mercetree\Shop\View\PreferencesInterface;
use Mateusz\Mercetree\TestApplication;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

#[CoversClass(ShopComponent::class)]
class ShopComponentTest extends TestCase
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @uses ComponentManager
     */
    public function testFactory()
    {
        $testApp = TestApplication::getInstance();

        $componentManager = $testApp->getService(ComponentManagerInterface::class);

        self::assertInstanceOf(ComponentManagerInterface::class, $componentManager);

        if (! $componentManager instanceof ComponentManager) {
            self::markTestSkipped('Unexpected ComponentManager class');
            return;
        }

        $shopComponent = $componentManager->get(ShopComponentInterface::class);

        self::assertInstanceOf(ShopComponent::class, $shopComponent);

        return $shopComponent;
    }

    /**
     * @covers ShopComponent::getViewPreferences
     * @covers ShopComponent::getCurrencyRateDataPresenter
     * @depends testFactory
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testComposition(ShopComponent $shopComponent)
    {
        self::assertInstanceOf(PreferencesInterface::class, $shopComponent->getViewPreferences());
        self::assertInstanceOf(PresenterInterface::class, $shopComponent->getCurrencyRateDataPresenter());
    }
}

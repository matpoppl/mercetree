<?php

use Mateusz\Mercetree\Application;
use Mateusz\Mercetree\Shop\ShopComponentInterface;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface;
use Mateusz\Mercetree\View\Renderer\ViewRendererInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\MockOrderRequest;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\MockOrderRequestItem;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrderExceptionInterface;

/** @var ShopComponentInterface $shop */
/** @var TreeConfiguratorComponentInterface $component */
/** @var ViewRendererInterface $view */

require __DIR__ . '/../vendor/autoload.php';

$app = Application::create(require __DIR__ . '/../configs/app.php');

$shop = $app->getComponent(ShopComponentInterface::class);

$request = new MockOrderRequest('id:99', [
    new MockOrderRequestItem('bauble:small', 4),
    new MockOrderRequestItem('bauble:medium', 4),
    new MockOrderRequestItem('bauble:big', 4),

    // testing rollback
    //new MockOrderRequestItem('READ_OUT_OF_STOCK', 4),
    //new MockOrderRequestItem('WRITE_ERROR', 4), // is EventStore write critical ?
    //new MockOrderRequestItem('ORDER_ERROR', 4),
]);

try {
    $created = $shop->getCreateOrder()->create($request);
} catch (CreateOrderExceptionInterface $ex) {
    echo $ex->getMessage();
    return;
}

if (! $created) {
    echo "## CREATE ERROR\n";
    return;
}

echo "## ORDER `{$created->getOrder()->getId()}`\n";

foreach ($created->getItems() as $item) {
    echo "- `{$item->getProductId()}` x{$item->getQuantity()}\n";
}


<?php

use Mateusz\Mercetree\Application;
use Mateusz\Mercetree\Shop\ShopComponentInterface;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface;
use Mateusz\Mercetree\View\Renderer\ViewRendererInterface;

/** @var ShopComponentInterface $shop */
/** @var TreeConfiguratorComponentInterface $component */
/** @var ViewRendererInterface $view */

require __DIR__ . '/../vendor/autoload.php';

$app = Application::create(require __DIR__ . '/../configs/app.php');

$shop = $app->getComponent(ShopComponentInterface::class);
$component = $app->getComponent(TreeConfiguratorComponentInterface::class);

$view = $app->getService(ViewRendererInterface::class);

$configurator = $component->getConfiguratorLoader()->load('tree:big');

$configurator->getRow('row0')
    ->add('model:showman/size:big/coating(hand-paint)')
    ->add('model:santa/size:big/coating(hand-paint)')
    ->add('model:reindeer/size:big/coating(hand-paint)')
    ->add('model:bauble/size:small/coating(color:red)')
    ->add('model:bauble/size:small/coating(color:yellow)')
    ->add('model:bauble/size:medium/coating(color:green)');

$configurator->getRow('row1')
    ->add('model:showman/size:big/coating(hand-paint)')
    ->add('model:santa/size:big/coating(hand-paint)')
    ->add('model:reindeer/size:big/coating(hand-paint)')
    ->add('model:bauble/size:small/coating(color:yellow)')
    ->add('model:bauble/size:medium/coating(color:green)');

$configurator->getRow('row2')
    ->add('model:bauble/size:small/coating(color:red)')
    ->add('model:bauble/size:small/coating(color:blue)')
    ->add('model:bauble/size:small/coating(color:yellow)')
    ->add('model:bauble/size:medium/coating(color:green)');

$configurator->getRow('row3')
    ->add('model:bauble/size:medium/coating(color:white)')
    ->add('model:bauble/size:medium/coating(color:pink)')
    ->add('model:bauble/size:small/coating(color:red)');

$configurator->getRow('row4')
    ->add('model:bauble/size:medium/coating(color:pink)')
    ->add('model:bauble/size:medium/coating(color:green)');

$configurator->getRow('row5')
    ->add('model:bauble/size:medium/coating(color:pink)');

$validationResults = $configurator->validate();

$salesSummary = $configurator->getSaleSummary();

echo $view->render('validation-results.phtml', ['results' => $validationResults]);

if (! $validationResults->isValid()) return;

echo $view->render('sales-summary.phtml', ['shop' => $shop, 'salesSummary' => $salesSummary]);

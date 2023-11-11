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

?><!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
    <title></title>
    <style>

        .prices {
            margin: 0 0 1em;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(6, auto);
        }

        .prices dd,
        .prices dt { padding: 0; margin: 0; }

    </style>
</head>
<body>

<pre><?php

    //$tmp = require __DIR__ . '/../examples/build-tree.php';
    //$tmp = require __DIR__ . '/../examples/build-specs.php';
    //$tmp = require __DIR__ . '/../examples/dbal.php';
    //$tmp = require __DIR__ . '/../examples/data.php';
    //$tmp = require __DIR__ . '/../examples/rules.php';

    $configurator = $component->getConfiguratorLoader()->load('tree:small');

    $configurator->getRow('row0')
        ->add('model:bauble/size:small/coating(color:red)')
        ->add('model:bauble/size:small/coating(color:blue)')
        ->add('model:bauble/size:small/coating(color:yellow)')
        ->add('model:bauble/size:medium/coating(color:green)');

    $configurator->getRow('row1')
        ->add('model:bauble/size:medium/coating(color:white)')
        ->add('model:bauble/size:medium/coating(color:pink)')
        ->add('model:bauble/size:small/coating(color:red)');

    $configurator->getRow('row2')
        ->add('model:bauble/size:medium/coating(color:pink)')
        ->add('model:bauble/size:medium/coating(color:green)');

    $configurator->getRow('row3')
        ->add('model:bauble/size:medium/coating(color:pink)');

    $validationResults = $configurator->validate();


    $salesSummary = $configurator->getSaleSummary();
?></pre>

<?= $view->render('validation-results.phtml', ['results' => $validationResults]) ?>

<p><?= $view->render('product-price.phtml', ['shop' => $shop, 'product' => $salesSummary->getBaseProduct()]) ?></p>
<ul>
<?php foreach ($salesSummary->getDecorations() as $decoration): ?>
    <li><?= $view->render('product-price.phtml', ['shop' => $shop, 'product' => $decoration]) ?></li>
<?php endforeach; ?>
</ul>

</body>
</html>

<?php

use Mateusz\Mercetree\Application;
use Mateusz\Mercetree\Shop\ShopComponent;

require __DIR__ . '/../vendor/autoload.php';

$app = Application::create(require __DIR__ . '/../configs/app.php');

$products = [];



?><!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
</head>
<body>

<table>

<tbody>
<?php foreach ($products as $productEntity): $product = $productPresenter->present($productEntity); ?>
<tr>
	<th><?php $product['name'] ?></th>
	<td><?php $currencyFormatter->format($product['priceNet'], 1) ?></td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

<pre><?php

$shop = $app->getComponent(ShopComponent::class);

print_r( $shop->getViewPreferences()->getCurrencyCode()->getCurrencyCode() );

?></pre>

</body>
</html>
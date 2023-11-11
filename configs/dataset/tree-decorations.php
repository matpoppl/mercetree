<?php

use Mateusz\Mercetree\TreeConfigurator\Feature\HandPainted;
use Mateusz\Mercetree\TreeConfigurator\Feature\Color;
use Mateusz\Mercetree\TreeConfigurator\Feature\SizeSymbol;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;

$taxCurrency = [ 'tax_rate' => 23, 'currency_code' => 'PLN' ];

$treeDecorations = [
    /** @see Bauble::getFeatureSymbol() */
    /** @see SizeSymbol::getFeatureSymbol() */
    /** @see Color::getFeatureSymbol() */
    [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:red', 'price' => 3.3 ] + $taxCurrency,
    [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:blue', 'price' => 3.5 ] + $taxCurrency,
    [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:yellow', 'price' => 3.6 ] + $taxCurrency,

    [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:green', 'price' => 4.44 ] + $taxCurrency,
    [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:white', 'price' => 5.55 ] + $taxCurrency,
    [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:pink', 'price' => 6.66 ] + $taxCurrency,

    /** @see HandPainted::getFeatureSymbol() */
    [ 'size' => 'big', 'model' => 'showman', 'coating' => 'hand-paint', 'price' => 8 ] + $taxCurrency,
    [ 'size' => 'big', 'model' => 'santa', 'coating' => 'hand-paint', 'price' => 8 ] + $taxCurrency,
    [ 'size' => 'big', 'model' => 'reindeer', 'coating' => 'hand-paint', 'price' => 8 ] + $taxCurrency,
];

return $treeDecorations;

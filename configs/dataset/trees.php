<?php

/**
 * @see \Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity
 */

$taxCurrency = [ 'tax_rate' => 23, 'currency_symbol' => 'PLN' ];

$trees = [
    // ID=tree:small
    ['size' => 'small', 'price' => 100, ] + $taxCurrency,
    // ID=tree:small
    ['size' => 'small', 'price' => 200, ] + $taxCurrency,
    // ID=tree:big
    ['size' => 'big', 'price' => 250, ] + $taxCurrency,
];

return $trees;

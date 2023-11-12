<?php

/**
 * @see \Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity
 */

$taxCurrency = [ 'tax_rate' => 23, 'currency_code' => 'PLN' ];

$trees = [
    // ID=tree:small
    ['size' => 'small', 'price' => 100 ] + $taxCurrency,
    // ID=tree:medium
    ['size' => 'medium', 'price' => 200 ] + $taxCurrency,
    // ID=tree:big
    ['size' => 'big', 'price' => 250 ] + $taxCurrency,
];

return $trees;

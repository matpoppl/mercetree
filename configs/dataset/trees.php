<?php

$taxCurrency = [ 'tax_rate' => 23, 'currency_symbol' => 'PLN' ];

$trees = [
    ['size' => 'small', 'rows' => '4,3,2,1', 'price' => 100, ] + $taxCurrency,
    ['size' => 'medium', 'rows' => '5,4,3,2,1', 'price' => 200, ] + $taxCurrency,
    ['size' => 'big', 'rows' => '6,5,4,3,2,1', 'price' => 250, ] + $taxCurrency,
];

return $trees;

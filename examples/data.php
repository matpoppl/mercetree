<?php

use Mateusz\Mercetree\TreeConfigurator\Data\Transform\ExampleFile;

$taxCurrency = [ 'tax_rate' => 23, 'currency_symbol' => 'PLN' ];

$trees = [
    ['size' => 'small', 'rows' => '1,3,2,4', 'price' => 100, ] + $taxCurrency,
    ['size' => 'medium', 'rows' => '1,3,2,4,5', 'price' => 200, ] + $taxCurrency,
    ['size' => 'big', 'rows' => '1,3,2,4,5,6', 'price' => 250, ] + $taxCurrency,
];

$treeDecorations = [
    [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:red', 'price' => 3.3 ] + $taxCurrency,
    [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:blue', 'price' => 3.5 ] + $taxCurrency,
    [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:yellow', 'price' => 3.6 ] + $taxCurrency,

    [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:green', 'price' => 4.44 ] + $taxCurrency,
    [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:white', 'price' => 5.55 ] + $taxCurrency,
    [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:pink', 'price' => 6.66 ] + $taxCurrency,

    [ 'size' => 'big', 'model' => 'showman', 'coating' => 'hand-paint', 'price' => 8 ] + $taxCurrency,
    [ 'size' => 'big', 'model' => 'santa', 'coating' => 'hand-paint', 'price' => 8 ] + $taxCurrency,
    [ 'size' => 'big', 'model' => 'reindeer', 'coating' => 'hand-paint', 'price' => 8 ] + $taxCurrency,
];

/***
 * [ tree=size:small | decoration=model:bauble,size:small,color:red,size:small ]
 */

$relation_TreeSize_Baubles = [
    [
        'tree_size' => 'small',
        'decoration' => [
            'size' => ['small', 'medium'],
            'model' => '__ANY__',
            'color' => '__ANY__',
        ]
    ], [
        'tree_size' => 'medium',
        'decoration' => [
            'model' => '__ANY__',
            'size' => '__ANY__',
            'color' => '__ANY__',
        ]
    ], [
        'tree_size' => 'big',
        'decoration' => [
            'model' => '__ANY__',
            'size' => '__ANY__',
            'color' => '__ANY__',
        ]
    ],
];

return ExampleFile::create([
    'trees' => $trees,
    'tree-decorations' => $treeDecorations,
]);

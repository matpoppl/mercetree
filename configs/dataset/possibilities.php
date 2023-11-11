<?php

/** @see \Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\PossibilitiesBuilder */

return [
    [
        'tree' => [ 'size' => ['small'] ],
        'decoration' => [
            'size' => ['small', 'medium'],
            'model' => '__ANY__',
            'coating' => '__ANY__',
        ]
    ], [
        'tree' => [ 'size' => ['medium'] ],
        'decoration' => [
            'model' => '__ANY__',
            'size' => '__ANY__',
            'coating' => '__ANY__',
        ]
    ], [
        'tree' => [ 'size' => ['big'] ],
        'decoration' => [
            'model' => '__ANY__',
            'size' => '__ANY__',
            'coating' => '__ANY__',
        ]
    ],
];

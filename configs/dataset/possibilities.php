<?php

/** @see \Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\PossibilitiesBuilder */

return [
    [
        'tree' => [ 'size' => ['small'] ],
        'decoration' => [
            'size' => ['small', 'medium'],
            'coating' => '__ANY__',
            'model' => '__ANY__',
        ]
    ], [
        'tree' => [ 'size' => ['medium'] ],
        'decoration' => [
            'size' => '__ANY__',
            'coating' => '__ANY__',
            'model' => '__ANY__',
        ]
    ], [
        'tree' => [ 'size' => ['big'] ],
        'decoration' => [
            'size' => '__ANY__',
            'coating' => '__ANY__',
            'model' => '__ANY__',
        ]
    ],
];

<?php

static $options = null;
static $ids = null;

if (null === $options) {

    $options = [
        'small' => [
            [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:red' ],
            [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:blue' ],
            [ 'size' => 'small', 'model' => 'bauble', 'coating' => 'color:yellow' ],
        ],
        'medium' => [
            [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:green' ],
            [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:white' ],
            [ 'size' => 'medium', 'model' => 'bauble', 'coating' => 'color:pink' ],
        ],
        'big' => [
            [ 'size' => 'big', 'model' => 'showman', 'coating' => 'hand-paint' ],
            [ 'size' => 'big', 'model' => 'santa', 'coating' => 'hand-paint' ],
            [ 'size' => 'big', 'model' => 'reindeer', 'coating' => 'hand-paint' ],
        ],
    ];

    $ids = [];
    foreach ($options as $key => $sizeRecords) {
        $ids[$key] = array_map(fn($opts) => "model:{$opts['model']}/size:{$opts['size']}/coating({$opts['coating']})", $sizeRecords);
    }
}

return [
    'options' => $options,
    'ids' => $ids,
];

<?php

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\TreesAdapter;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepository;

$data = require __DIR__ . '/data.php';

return [
    'trees' => new TreesAdapter($data['trees']),
];

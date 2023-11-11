<?php

$small = require __DIR__ . '/constraints-small.php';
$medium = require __DIR__ . '/constraints-medium.php';
$big = require __DIR__ . '/constraints-big.php';

return array_merge($small, $medium, $big);

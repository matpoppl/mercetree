<?php

namespace Mateusz\Mercetree\Application\Config\Loader\File;

interface PhpConfigFileLoaderInterface
{
    public function load(string $pathname) : array;
}

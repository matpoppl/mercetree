<?php

namespace Mateusz\Mercetree\ServiceManager\Config;

interface ServiceConfigResolverInterface
{
    const CONFIG_KEY = 'config_file';

    public function get(string $id, ?ConfigInterface $from = null) : array;
}

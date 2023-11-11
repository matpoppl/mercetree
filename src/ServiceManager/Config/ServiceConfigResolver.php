<?php

namespace Mateusz\Mercetree\ServiceManager\Config;

use Mateusz\Mercetree\Application\Config\Loader\File\PhpConfigFileLoaderInterface;

class ServiceConfigResolver implements ServiceConfigResolverInterface
{
    public function __construct(private readonly ConfigInterface $config, private readonly PhpConfigFileLoaderInterface $loader)
    {}

    /**
     * @throws InvalidTypeException
     */
    public function get(string $id, ?ConfigInterface $from = null) : array
    {
        $from ??= $this->config;
        $config = $from->getArray($id);

        $configFile = $config[self::CONFIG_KEY] ?? null;

        if (! $configFile) {
            return $config;
        }

        return $this->loader->load($configFile);
    }
}

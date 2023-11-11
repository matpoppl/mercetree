<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Constraint;

use Mateusz\Mercetree\Application\Config\Loader\File\ConfigFileException;
use Psr\Container\ContainerInterface;

class PhpConfigFileLoader implements PhpConfigFileLoaderInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ConfigFileException
     */
    public function load(string $pathname) : array
    {
        if (! $pathname) {
            throw ConfigFileException::createInvalidPathname($pathname);
        }

        if (! is_file($pathname)) {
            throw ConfigFileException::createNotFound($pathname);
        }

        if (! is_readable($pathname)) {
            throw ConfigFileException::createNotReadable($pathname);
        }

        $sandbox = function($__pathname, ContainerInterface $container) {
            return require $__pathname;
        };

        $config = $sandbox($pathname, $this->container);

        if (! is_array($config)) {
            throw ConfigFileException::createNotArray($pathname, $config);
        }

        return $config;
    }
}

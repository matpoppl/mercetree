<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider\ProviderExceptionInterface;

class ConfiguratorLoaderException extends \Exception implements ConfiguratorLoaderExceptionInterface
{
    public static function builtTreeError(ProviderExceptionInterface $exception) : static
    {
        return new static("BuiltTree load error", self::CODE_BUILT_TREE_ERROR, $exception);
    }

    public static function collectorError(Collector\ProductException $exception) : static
    {
        return new static("Collector load error", self::CODE_COLLECTOR_ERROR, $exception);
    }
}

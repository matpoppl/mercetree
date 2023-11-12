<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider;

class ProviderException extends \Exception implements ProviderExceptionInterface
{
    public static function notFound(string $treeId) : static
    {
        return new static("Configuration not found for BuiltTree {$treeId}`", self::CODE_NOT_FOUND);
    }
}

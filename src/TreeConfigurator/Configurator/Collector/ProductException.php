<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

class ProductException extends \Exception
{
    const CODE_PRODUCT_NOT_FOUND = 1;
    const CODE_FEATURE_NOT_FOUND = 2;

    public static function productNotFound(string $id) : static
    {
        return new static("Product `{$id}` not found", self::CODE_PRODUCT_NOT_FOUND);
    }

    public static function featureNotFound(string $id) : static
    {
        return new static("Feature `{$id}` not found", self::CODE_FEATURE_NOT_FOUND);
    }
}

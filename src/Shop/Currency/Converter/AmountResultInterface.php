<?php

namespace Mateusz\Mercetree\Shop\Currency\Converter;

interface AmountResultInterface
{
    public function getAmount() : float;
    public function getCurrencyCode() : string;
}

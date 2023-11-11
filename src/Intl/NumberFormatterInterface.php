<?php

namespace Mateusz\Mercetree\Intl;

interface NumberFormatterInterface
{
    public function formatCurrency(float $number, ?string $currencySymbol = null) : string|false;
}

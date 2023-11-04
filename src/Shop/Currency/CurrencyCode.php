<?php

namespace Mateusz\Mercetree\Shop\Currency;

class CurrencyCode implements CurrencyCodeInterface
{
    private string $currencyCode;
    private string $symbol;
    
    public function __construct(array $options)
    {
        $this->currencyCode = $options['currency_code'] ?? null;
        $this->symbol = $options['symbol'] ?? null;
    }
    
    public function getCurrencyCode() : string
    {
        return $this->currencyCode;
    }
    
    /**
     * Symbol, ex. $, €, zł
     * @return string
     */
    public function getSymbol() : string
    {
        return $this->symbol;
    }
}

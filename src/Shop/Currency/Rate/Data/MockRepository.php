<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use DateTimeInterface;

class MockRepository implements RepositoryInterface
{
    private array $rates = [];
    
    public function __construct(array $options = null)
    {
        $this->rates = $options['rates'] ?? [];
    }
    
    public function get(CurrencyCodeInterface $currencySymbol, DateTimeInterface $date) : ?float
    {
        $symbol = $currencySymbol->getSymbol();
        $date = $date->format('Y-m-d');
        
        $key = "{$symbol}-{$date}";
        
        return $this->rates[$key] ?? null;
    }
}

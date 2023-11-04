<?php

namespace Mateusz\Mercetree\Shop\Product\View;

class ProductPresenter
{
    public function __construct()
    {
    }
    
    public function getPriceNetFormatted2()
    {
        
        $date = null;
        $basePrice = $this->product->getPrice();
        $taxRate = $this->product->getTaxRate();
        $currency = $this->product->getCurrencySymbol();
        $quantity = 1;
        
        $this->locale->getCurrencySymbol();
        $currencyRate = $this->currencyRate->get();
        
        return $this->currencyFormatter->format();
    }
    
    public function getPriceNetFormatted(ProductPriceInterface $product)
    {
        
        $date = null;
        $basePrice = $this->product->getPrice();
        $taxRate = $this->product->getTaxRate();
        $currency = $this->product->getCurrencySymbol();
        $quantity = 1;
        
        $this->locale->getCurrencySymbol();
        $currencyRate = $this->currencyRate->get();
        
        return $this->currencyFormatter->format();
    }
}

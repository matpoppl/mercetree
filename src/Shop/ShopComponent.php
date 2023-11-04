<?php

namespace Mateusz\Mercetree\Shop;

use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareTrait;
use Mateusz\Mercetree\Shop\View\PreferencesInterface;

class ShopComponent implements ServiceManagerConstructorAwareInterface
{
    use ServiceManagerConstructorAwareTrait;
    
    public function getViewPreferences() : PreferencesInterface
    {
        return $this->serviceManager->get(PreferencesInterface::class);
    }
}

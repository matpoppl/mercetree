<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

interface ProductInterface extends ProductPriceInterface
{
    public function getId() : string;
    public function getName() : string;
}

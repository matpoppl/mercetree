<?php

namespace Mateusz\Mercetree\EntityManager\EntitySpecs;

interface EntitySpecsManagerInterface
{
    public function get(string $id) : EntitySpecsInterface;
}

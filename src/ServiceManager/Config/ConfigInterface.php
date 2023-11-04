<?php

namespace Mateusz\Mercetree\ServiceManager\Config;

interface ConfigInterface
{
    public function get(string $id) : mixed;
    
    /**
     * 
     * @param string $id
     * @throws InvalidTypeException
     * @return array
     */
    public function getArray(string $id) : array;
}

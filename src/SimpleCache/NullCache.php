<?php

namespace Mateusz\Mercetree\SimpleCache;

use Psr\SimpleCache\CacheInterface;

class NullCache implements CacheInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return $default;
    }
    
    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        return false;
    }
    
    public function delete(string $key): bool
    {
        return false;
    }
    
    public function clear(): bool
    {
        return false;
    }
    
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        return [];
    }
    
    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        return false;
    }
    
    public function deleteMultiple(iterable $keys): bool
    {
        return false;
    }
    
    public function has(string $key): bool
    {
        return false;
    }
}

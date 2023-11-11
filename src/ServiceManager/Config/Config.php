<?php

namespace Mateusz\Mercetree\ServiceManager\Config;

use function gettype;

class Config implements ConfigInterface
{
    public function __construct(private readonly array $data)
    {}

    public function get(string $id) : mixed
    {
        return $this->data[$id] ?? null;
    }

    public function getArray(string $id) : array
    {
        $val = $this->get($id);

        if (is_array($val)) {
            return $val;
        }

        if (null === $val) {
            return [];
        }

        throw InvalidTypeException::create(gettype($val), 'array');
    }
}

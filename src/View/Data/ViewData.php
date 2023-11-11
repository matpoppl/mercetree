<?php

namespace Mateusz\Mercetree\View\Data;

use Mateusz\Mercetree\Intl\Translator\TranslatorInterface;

class ViewData implements ViewDataInterface
{
    public function __construct(private readonly TranslatorInterface $translator, private array $data)
    {
    }

    public function has(string $id) : bool
    {
        return array_key_exists($id, $this->data);
    }

    public function get(string $id, mixed $default = null) : mixed
    {
        return $this->data[$id] ?? $default;
    }

    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }
}

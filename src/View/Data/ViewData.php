<?php

namespace Mateusz\Mercetree\View\Data;

use Mateusz\Mercetree\Intl\Translator\TranslatorInterface;
use Mateusz\Mercetree\View\Renderer\ViewRendererInterface;

class ViewData implements ViewDataInterface
{
    public function __construct(private readonly ViewRendererInterface $viewRenderer, private readonly TranslatorInterface $translator, private readonly array $data)
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

    public function render(string $template, array $data): string
    {
        return $this->viewRenderer->render($template, $data);
    }
}

<?php

namespace Mateusz\Mercetree\View\Renderer;

interface ViewRendererInterface
{
    /**
     * @param string $template
     * @param array<string, mixed> $data
     * @return string
     * @throws TemplateException
     */
    public function render(string $template, array $data) : string;
}

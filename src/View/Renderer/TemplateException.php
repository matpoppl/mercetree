<?php

namespace Mateusz\Mercetree\View\Renderer;

class TemplateException extends \RuntimeException
{
    const CODE_NOT_FOUND = 1;

    public static function notFound(string $template, array $paths) : TemplateException
    {
        $paths = implode(', ', $paths);
        return new static("Template file `{$template}` dont exists in `{$paths}`", self::CODE_NOT_FOUND);
    }
}

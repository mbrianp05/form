<?php

namespace Laton\Framework\Components\Form;

use InvalidArgumentException;

class Renderer
{
    public static function openTag(string $name, array $attributes = []): string
    {
        $tag = '<' . $name;

        foreach ($attributes as $attribute => $value) {
            $attributes .= ' ' . $attribute . '="' . $value .'"';
        }

        return $tag . '>';
    }

    public static function closeTag(string $name): string
    {
        return '</' . $name . '>';
    }

    public static function tag(string $name, string $content = '', array $attributes = [], bool $short = false): string
    {
        $tag = static::openTag($name, $attributes);

        if (!empty($content) && false == $short) {
            throw new InvalidArgumentException('Cannot put content to a short tag');
        }

        if (false == $short) {
            $tag .= $content . static::closeTag($name);
        }

        return $tag;
    }
}
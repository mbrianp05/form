<?php

namespace Laton\Framework\Components\Form\Types;

use Laton\Framework\Components\Form\Renderer;

class TextType implements TypeInterface
{
    public function render(array $options = []): string
    {
        $attributes = array_merge(
            $options['attrs'],
            [
                'name' => $options['name'],
                'id' => $options['id'],
                'value' => $options['value']
            ]
        );

        return Renderer::tag('input', attributes: $attributes, short: false);
    }
}
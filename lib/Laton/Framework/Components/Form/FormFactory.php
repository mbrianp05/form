<?php

namespace Laton\Framework\Components\Form;

use InvalidArgumentException;
use Laton\Framework\Components\Form\Types\TextType;

class FormFactory
{
    /**
     * @var FormControl[]
     */
    protected array $controls = [];

    public function __construct(public array $options)
    {
    }

    public function resolveOptions(array $options = []): array
    {
        $optionsResolver = new OptionsResolver($this->options);
        return $optionsResolver->resolve($options);
    }

    public function addControl(string $name, string $type = TextType::class, array $options = []): static
    {
        $control = new FormControl($name, new $type($name, $options), $options);
        $this->controls[$name] = $control;

        return $this;
    }

    public function getControl(string $name): FormControl
    {
        if (!isset($this->controls[$name])) {
            throw new InvalidArgumentException(\sprintf('Field %s was not found', $name));
        }

        return $this->controls[$name];
    }

    public function renderStart(array $options = []): string
    {
        $options = $this->resolveOptions($options);
        $attributes = \array_merge($options['attr'], [
            'method' => $options['http_method'],
            'action' => $options['path'],
        ]);

        return Renderer::openTag('form', attributes: $attributes);
    }

    public function renderClose(): string
    {
        return Renderer::closeTag('form');
    }
    
    public function isValid(): bool
    {
        foreach ($this->controls as $control) {
            if ($control->hasError())
                return false;
        }

        return true;
    }
}
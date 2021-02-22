<?php

namespace Laton\Framework\Components\Form;

use Laton\Framework\Components\Form\Types\TypeInterface;
use Laton\Framework\Components\Form\Validators\ValidatorInterface;

class FormControl
{
    protected array $errors = [];

    /**
     * FormControl constructor.
     * @param string $name
     * @param TypeInterface $type
     * @param string[] $options
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        protected string $name,
        protected TypeInterface $type,
        protected array $options = [],
        protected array $validators = [],
    )
    {
        $this->options['name'] = $name;
    }

    public function resolveOptions(array $options = []): array
    {
        $optionsResolver = new OptionsResolver($this->options);
        return $optionsResolver->resolve($options);
    }

    /**
     * $name property is readonly so it cannot be public
     * so far in php cannot be set if a variable can be write
     * outside the class, so it's needed to create a getter.
     */
    public function getName(): string
    {
        return $this->options['name'];
    }

    public function getValue(): ?string
    {
        return $this->options['value'] ?? null;
    }

    public function setValue(string $value): void
    {
        $this->options['value'] = $value;
    }

    public function renderControl(array $options = []): string
    {
        return $this->type->render($this->resolveOptions($options));
    }

    public function renderLabel(array $options): string
    {
        $options = $this->resolveOptions($options);

        return Renderer::tag('label', $options['label'], ['for' => $options['id']]);
    }

    public function renderErrors(callable $renderer = null): string
    {
        if (null != $renderer) {
            return $renderer($this->errors);
        }

        $html = Renderer::openTag('ul');

        foreach ($this->errors as $error) {
            $html .= Renderer::tag('li', $error);
        }

        return $html . Renderer::closeTag('ul');
    }

    public function validate(): void
    {
        foreach ($this->validators as $validator) {
            if ($validator->validate($this->options['value'])) {
                $this->errors[] = $validator->getErrorMessage();
            }
        }
    }
}
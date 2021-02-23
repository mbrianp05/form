<?php

namespace Laton\Framework\Components\Form;

class FormView
{
    public function __construct(protected FormFactory $form)
    {
    }

    public function formStart(array $options = []): string
    {
        return $this->form->renderStart($options);
    }

    public function formEnd(): string
    {
        return $this->form->renderClose();
    }

    public function renderWidget(string $name, array $options = []): ?string
    {
        return $this->form->getControl($name)?->renderControl($options);
    }

    public function renderErrors(string $name, callable $renderer = null): ?string
    {
        return $this->form->getControl($name)?->renderErrors($renderer);
    }

    public function renderLabel(string $name, array $options = []): ?string
    {
        return $this->form->getControl($name)?->renderLabel($options);
    }
}
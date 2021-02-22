<?php

namespace Laton\Framework\Components\Form\Validators;

class Length implements ValidatorInterface
{
    protected ?string $value = null;

    public function __construct(protected ?int $min = null, protected ?int $max = null, protected ?string $message = null)
    {
    }

    public function validate(string $value): bool
    {
        $this->value = $value;

        if ($this->isRange()) {
            return \strlen($value) >= $this->min && \strlen($value) <= $this->max;
        }

        if ($this->isMin() && \strlen($value) >= $this->min) {
            return true;
        }

        if ($this->isMax() && \strlen($value) <= $this->max) {
            return true;
        }

        return false;
    }

    public function getErrorMessage(): string
    {
        $message = $this->message;

        if (null === $message) {
            // All the possible error messages starts with the same text
            $message = 'Invalid value %s, value must have ';

            $message .= match (true) {
                $this->isRange() => 'between %s and %s characters',
                $this->isMax() => 'less than %s characters',
                $this->isMin() => 'more than %s characters',
            };
        }

        return $message;
    }

    protected function isMax(): bool
    {
        return null === $this->min && null !== $this->max;
    }

    protected function isMin(): bool
    {
        return null === $this->max && null !== $this->min;
    }

    protected function isRange(): bool
    {
        return null !== $this->min && null !== $this->max;
    }
}
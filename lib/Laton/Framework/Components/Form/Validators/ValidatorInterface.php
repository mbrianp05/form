<?php

namespace Laton\Framework\Components\Form\Validators;

interface ValidatorInterface
{
    public function validate(string $value): bool;

    public function getErrorMessage(): ?string;
}
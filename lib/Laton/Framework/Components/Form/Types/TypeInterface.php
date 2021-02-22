<?php

namespace Laton\Framework\Components\Form\Types;

interface TypeInterface
{
    public function render(array $options = []): string;
}
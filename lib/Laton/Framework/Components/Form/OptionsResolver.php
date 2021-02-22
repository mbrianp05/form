<?php

namespace Laton\Framework\Components\Form;

/**
 * Options resolver helps get some required options that were not
 * specified.
 *
 * For example, if you create a control and don't declares what the id attribute,
 * then this resolver will say that the ID is the same as the name of the control.
 *
 * And the same for the rest of necessary data.
 */
class OptionsResolver
{
    public function __construct(protected array $options)
    {
    }

    /**
     * Returns the resolved options.
     *
     * @param array $options
     * @return array
     */
    public function resolve(array $options = []): array
    {
        // When a form is created, it has default options
        // but they can be changed later when the form is being rendered
        // So the new options will replace the first ones
        $this->options = \array_merge($this->options, $options);

        if (!isset($this->options['label'])) {
            $this->options['label'] = \ucfirst($this->options['name']);
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->options['name'];
        }

        return $this->options;
    }
}
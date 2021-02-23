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

        // Set the label with same value as the name but with
        // the first letter in uppercase
        if (!isset($this->options['label'])) {
            $this->options['label'] = \ucfirst($this->options['name']);
        }

        // Set the ID with the same value as the name
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->options['name'];
        }

        // Init a default value
        if (!isset($this->options['value'])) {
            $this->options['value'] = '';
        }

        return $this->options;
    }
}
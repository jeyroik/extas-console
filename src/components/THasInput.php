<?php
namespace extas\components;

use extas\interfaces\IHasInput;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Trait THasInput
 *
 * @property array $config
 *
 * @package extas\components
 * @author jeyroik@gmail.com
 */
trait THasInput
{
    /**
     * @return InputInterface
     */
    public function getInput(): InputInterface
    {
        return $this->config[IHasInput::FIELD__INPUT];
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getInputOption(string $name, string $default = ''): string
    {
        return $this->getInput()->hasOption($name) ? $this->getInput()->getOption($name) : $default;
    }
}

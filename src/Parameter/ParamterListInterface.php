<?php

namespace Pars\Helper\Parameter;

/**
 * Interface ParamterListInterface
 * @package Pars\Helper\Parameter
 */
interface ParamterListInterface extends \Iterator, \Countable
{
    /**
     * @param ParameterInterface $parameter
     * @return $this
     */
    public function set(ParameterInterface $parameter): self;

    /**
     * @param string $key
     * @return ParameterInterface
     */
    public function get(string $key): ParameterInterface;

    /**
     * @param string $key
     * @return $this
     */
    public function unset(string $key): self;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @return array
     */
    public function toArray(): array;
}

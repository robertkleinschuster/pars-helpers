<?php

namespace Pars\Helper\Parameter;

/**
 * Class ParameterList
 * @package Pars\Helper\Parameter
 */
class ParameterList extends \IteratorIterator implements \Countable, ParamterListInterface
{

    public function __construct()
    {
        parent::__construct(new \ArrayIterator());
    }

    public function getInnerIterator(): \ArrayIterator
    {
        return parent::getInnerIterator();
    }

    /**
     * @return ParameterInterface
     */
    public function current(): ParameterInterface
    {
        return parent::current();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->getInnerIterator()->count();
    }

    /**
     * @param ParameterInterface $parameter
     * @return $this
     */
    public function set(ParameterInterface $parameter): self
    {
        $this->getInnerIterator()->offsetSet($parameter::name(), $parameter);
        return $this;
    }


    /**
     * @param string $key
     * @return ParameterInterface
     */
    public function get(string $key): ParameterInterface
    {
        return $this->getInnerIterator()->offsetGet($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->getInnerIterator()->offsetExists($key);
    }

    /**
     * @param string $key
     * @return $this|ParamterListInterface
     */
    public function unset(string $key): ParamterListInterface
    {
        $this->getInnerIterator()->offsetUnset($key);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $map = [];
        foreach ($this as $key => $value) {
            if ($value->hasData()) {
                $map[$key] = $value->toString();
            }
        }
        return $map;
    }
}

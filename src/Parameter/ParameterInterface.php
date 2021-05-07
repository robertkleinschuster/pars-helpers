<?php

namespace Pars\Helper\Parameter;

use Pars\Pattern\Exception\AttributeExistsException;
use Pars\Pattern\Exception\AttributeLockException;
use Pars\Pattern\Exception\AttributeNotFoundException;

interface ParameterInterface
{
    /**
     * @return string
     */
    public static function name(): string;

    /**
     * @param string $attribute
     * @return string
     */
    public static function nameAttr(string $attribute): string;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @param string|array $data
     * @return $this
     */
    public function fromData($data): self;

    /**
     * @param array $parameter
     * @return $this
     */
    public function fromArray(array $parameter): self;

    /**
     * @param string $parameter
     * @return $this
     */
    public function fromString(string $parameter): self;

    /**
     * @return bool
     */
    public function hasData(): bool;

    /**
     * @param string $action
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setAction(string $action);

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getAction(): string;
    public function hasAction(): bool;


    /**
     * @param string $action
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setController(string $action);

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getController(): string;

    /**
     * @return bool
     */
    public function hasController(): bool;

    /**
     * @return $this
     */
    public function clear(): self;

    /**
     * @return bool
     */
    public function hasHash(): bool;

    /**
     * @return string
     * @throws AttributeNotFoundException
     */
    public function getHash(): string;

    /**
     * @param string $hash
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setHash(string $hash): self;

}

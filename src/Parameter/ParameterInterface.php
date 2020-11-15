<?php

namespace Pars\Helper\Parameter;

interface ParameterInterface
{
    /**
     * @return string
     */
    public static function getParameterKey(): string;

    /**
     * @param string $attribute
     * @return string
     */
    public static function getFormKey(string $attribute): string;

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
}

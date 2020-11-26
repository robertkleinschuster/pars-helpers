<?php

namespace Pars\Helper\Parameter;

use Niceshops\Core\Attribute\AttributeAwareInterface;
use Niceshops\Core\Attribute\AttributeAwareTrait;

abstract class AbstractParameter implements ParameterInterface, AttributeAwareInterface
{
    use AttributeAwareTrait;

    /**
     * @var ParameterMapHelper
     */
    private ?ParameterMapHelper $parameterMapHelper = null;

    /**
     * @return ParameterMapHelper
     */
    protected function getParameterMapHelper(): ParameterMapHelper
    {
        if (null === $this->parameterMapHelper) {
            $this->parameterMapHelper = new ParameterMapHelper();
        }
        return $this->parameterMapHelper;
    }

    /**
     * @param string $parameter
     * @return AbstractParameter
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function fromString(string $parameter): self
    {
        $data = $this->getParameterMapHelper()->parseParameter($parameter);
        $this->fromArray($data);
        return $this;
    }

    /**
     * @param array $parameter
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function fromArray(array $parameter): self
    {
        foreach ($parameter as $key => $value) {
            $this->setAttribute($key, $value);
        }
        return $this;
    }

    /**
     * @param $data
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function fromData($data): self
    {
        if (is_string($data)) {
            $this->fromString($data);
        } elseif (is_array($data)) {
            $this->fromArray($data);
        } else {
            throw new InvalidParameterException('Invalid paremter data.');
        }
        return $this;
    }

    /**
     * @param string $attribute
     * @return string
     */
    public static function nameAttr(string $attribute): string
    {
        return static::name() . "[$attribute]";
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getParameterMapHelper()->generateParameter($this->getAttribute_List());
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->__toString();
    }

    /**
     * @return bool
     */
    public function hasData(): bool
    {
        return count($this->getAttribute_List()) > 0;
    }
}

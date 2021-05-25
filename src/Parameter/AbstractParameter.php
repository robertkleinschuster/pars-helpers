<?php

namespace Pars\Helper\Parameter;

use Pars\Helper\String\StringHelper;
use Pars\Pattern\Attribute\AttributeAwareInterface;
use Pars\Pattern\Attribute\AttributeAwareTrait;
use Pars\Pattern\Exception\AttributeExistsException;
use Pars\Pattern\Exception\AttributeLockException;
use Pars\Pattern\Exception\AttributeNotFoundException;

abstract class AbstractParameter implements ParameterInterface, AttributeAwareInterface
{
    use AttributeAwareTrait;

    public const ATTRIBUTE_ACTION = 'action';
    public const ATTRIBUTE_CONTROLLER = 'controller';
    public const ATTRIBUTE_HASH = 'hash';

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
     * @throws AttributeExistsException
     * @throws AttributeLockException
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
     * @throws AttributeExistsException
     * @throws AttributeLockException
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
     * @throws AttributeExistsException
     * @throws AttributeLockException
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


    /**
     * @param string $action
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setAction(string $action)
    {
        $this->setAttribute(self::ATTRIBUTE_ACTION, $action);
        return $this;
    }

    /**
     * @return string
     * @throws AttributeNotFoundException
     */
    public function getAction(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_ACTION);
    }


    /**
     * @param string $action
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setController(string $action)
    {
        $this->setAttribute(self::ATTRIBUTE_CONTROLLER, $action);
        return $this;
    }

    /**
     * @return string
     * @throws AttributeNotFoundException
     */
    public function getController(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_CONTROLLER);
    }

    /**
     * @return bool
     */
    public function hasAction(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_ACTION);
    }

    /**
     * @return bool
     */
    public function hasController(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_CONTROLLER);
    }

    /**
     * @return $this
     */
    public function clear(): self
    {
        foreach ($this->getAttributes() as $key => $value) {
            $this->unsetAttribute($key);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasHash(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_HASH);
    }

    /**
     * @return string
     * @throws AttributeNotFoundException
     */
    public function getHash(): string
    {
        return StringHelper::slugify($this->getAttribute(self::ATTRIBUTE_HASH));
    }

    /**
     * @param string $hash
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setHash(string $hash): self
    {
        return $this->setAttribute(self::ATTRIBUTE_HASH, $hash);
    }
}

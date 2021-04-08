<?php

namespace Pars\Helper\RouteParameter;

use Pars\Pattern\Attribute\AttributeAwareInterface;
use Pars\Pattern\Attribute\AttributeAwareTrait;

class RouteParameter implements AttributeAwareInterface
{
    use AttributeAwareTrait;

    public const ATTRIBUTE_ACTION = 'action';
    public const ATTRIBUTE_CONTROLLER = 'controller';

    /**
     * @param string $value
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setAction(string $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_ACTION, $value);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setController(string $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_CONTROLLER, $value);
        return $this;
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getAction(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_ACTION);
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
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
}

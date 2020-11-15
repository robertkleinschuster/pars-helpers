<?php

namespace Pars\Helper\RouteParameter;

use Niceshops\Core\Attribute\AttributeAwareInterface;
use Niceshops\Core\Attribute\AttributeAwareTrait;

class RouteParameter implements AttributeAwareInterface
{
    use AttributeAwareTrait;

    public const ATTRIBUTE_ACTION = 'action';
    public const ATTRIBUTE_CONTROLLER = 'controller';

    /**
     * @param string $value
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setAction(string $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_ACTION, $value);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setController(string $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_CONTROLLER, $value);
        return $this;
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getAction(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_ACTION);
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
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

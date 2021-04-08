<?php

namespace Pars\Helper\Parameter;

/**
 * Class OrderParameter
 * @package Pars\Helper\Parameter
 */
class OrderParameter extends AbstractParameter
{
    public const ATTRIBUTE_MODE = 'mode';
    public const ATTRIBUTE_FIELD = 'field';

    public const MODE_ASC = 'asc';
    public const MODE_DESC = 'desc';

    public static function name(): string
    {
        return 'order';
    }

    /**
     * @param string $mode
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setMode(string $mode)
    {
        $this->setAttribute(self::ATTRIBUTE_MODE, $mode);
        return $this;
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getMode(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_MODE);
    }

    /**
     * @return bool
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function hasMode(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_MODE);
    }

    /**
     * @param string $field
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setField(string $field)
    {
        $this->setAttribute(self::ATTRIBUTE_FIELD, $field);
        return $this;
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getField(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_FIELD);
    }

    /**
     * @return bool
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function hasField(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_FIELD);
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setAscending()
    {
        $this->setMode(self::MODE_ASC);
        return $this;
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setDescending()
    {
        $this->setMode(self::MODE_DESC);
        return $this;
    }
}

<?php

namespace Pars\Helper\Parameter;

use Pars\Pattern\Exception\AttributeExistsException;
use Pars\Pattern\Exception\AttributeLockException;
use Pars\Pattern\Exception\AttributeNotFoundException;

/**
 * Class CollapseParameter
 * @package Pars\Helper\Parameter
 */
class CollapseParameter extends AbstractParameter
{
    public const ATTRIBUTE_EXPANDED = 'expanded';
    public const ATTRIBUTE_ID = 'id';

    public static function name(): string
    {
        return 'collapsable';
    }

    /**
     * @param bool $expanded
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setExpanded(bool $expanded): self
    {
        $this->setAttribute(self::ATTRIBUTE_EXPANDED, $expanded ? "true": "false");
        return $this;
    }

    /**
     * @return bool
     * @throws AttributeNotFoundException
     */
    public function isExpanded(): bool
    {
        return $this->getAttribute(self::ATTRIBUTE_EXPANDED) === "true" ;
    }

    /**
     * @return bool
     */
    public function hasExpanded(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_EXPANDED);
    }

    /**
     * @param string $id
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setId(string $id): self
    {
        $this->setAttribute(self::ATTRIBUTE_ID, $id);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_ID);
    }

    /**
     * @return string
     * @throws AttributeNotFoundException
     */
    public function getId(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_ID);
    }
}

<?php

namespace Pars\Helper\Parameter;

/**
 * Class NavParameter
 * @package Pars\Helper\Parameter
 */
class NavParameter extends AbstractParameter
{
    public const ATTRIBUTE_INDEX = 'index';
    public const ATTRIBUTE_ID = 'id';

    public static function name(): string
    {
        return 'nav';
    }


    /**
     * @param int $index
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setIndex(int $index)
    {
        $this->setAttribute(self::ATTRIBUTE_INDEX, (string)$index);
        return $this;
    }

    /**
     * @return int
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getIndex(): int
    {
        return (int)$this->getAttribute(self::ATTRIBUTE_INDEX);
    }

    /**
     * @param string $id
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setId(string $id)
    {
        $this->setAttribute(self::ATTRIBUTE_ID, $id);
        return $this;
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getId(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_ID);
    }
}

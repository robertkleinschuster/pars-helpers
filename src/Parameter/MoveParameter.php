<?php

namespace Pars\Helper\Parameter;

/**
 * Class MoveParameter
 * @package Pars\Helper\Parameter
 */
class MoveParameter extends AbstractParameter
{
    public const ATTRIBUTE_STEPS = 'steps';
    public const ATTRIBUTE_REFERENCE_VALUE = 'referenceValue';


    public static function name(): string
    {
        return 'move';
    }

    /**
     * @param int $steps
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setSteps(int $steps)
    {
        $this->setAttribute(self::ATTRIBUTE_STEPS, (string)($steps));
        return $this;
    }

    /**
     * @return int
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getSteps(): int
    {
        return (int)$this->getAttribute(self::ATTRIBUTE_STEPS);
    }

    /**
     * @param string $referenceValue
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setReferenceValue($referenceValue)
    {
        $this->setAttribute(self::ATTRIBUTE_REFERENCE_VALUE, (string)($referenceValue));
        return $this;
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getReferenceValue(): ?string
    {
        return $this->hasAttribute(self::ATTRIBUTE_REFERENCE_VALUE) ?
            $this->getAttribute(self::ATTRIBUTE_REFERENCE_VALUE) : null;
    }

    /**
     * @param string $field
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setUp()
    {
        $this->setSteps(-1);
        return $this;
    }

    /**
     * @param string $field
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setDown()
    {
        $this->setSteps(1);
        return $this;
    }
}

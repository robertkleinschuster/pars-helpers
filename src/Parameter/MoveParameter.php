<?php

namespace Pars\Helper\Parameter;

use Pars\Pattern\Exception\AttributeExistsException;
use Pars\Pattern\Exception\AttributeLockException;

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
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setSteps(int $steps)
    {
        $this->setAttribute(self::ATTRIBUTE_STEPS, (string)($steps));
        return $this;
    }

    /**
     * @return int
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getSteps(): int
    {
        return (int)$this->getAttribute(self::ATTRIBUTE_STEPS);
    }

    /**
     * @param string $referenceValue
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setReferenceValue($referenceValue)
    {
        $this->setAttribute(self::ATTRIBUTE_REFERENCE_VALUE, (string)($referenceValue));
        return $this;
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getReferenceValue(): ?string
    {
        return $this->hasAttribute(self::ATTRIBUTE_REFERENCE_VALUE) ?
            $this->getAttribute(self::ATTRIBUTE_REFERENCE_VALUE) : null;
    }

    /**
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setUp(): self
    {
        $this->setSteps(-1);
        return $this;
    }

    /**
     * @return $this
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setDown(): self
    {
        $this->setSteps(1);
        return $this;
    }

    /**
     * @return MoveParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public static function up(): self
    {
        return (new static())->setUp();
    }

    /**
     * @return MoveParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public static function down(): self
    {
        return (new static)->setDown();
    }
}

<?php

namespace Pars\Helper\Parameter;

class SubmitParameter extends AbstractParameter
{
    public const ATTRIBUTE_MODE = 'mode';
    public const MODE_CREATE = 'create';
    public const MODE_SAVE = 'save';
    public const MODE_DELETE = 'delete';

    public static function name(): string
    {
        return 'submit';
    }


    /**
     * @param string $mode
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setMode(string $mode)
    {
        $this->setAttribute(self::ATTRIBUTE_MODE, $mode);
        return $this;
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getMode(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_MODE);
    }

    /**
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setCreate()
    {
        $this->setMode(self::MODE_CREATE);
        return $this;
    }

    /**
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setDelete()
    {
        $this->setMode(self::MODE_DELETE);
        return $this;
    }

    /**
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setSave()
    {
        $this->setMode(self::MODE_SAVE);
        return $this;
    }

    public static function createDelete()
    {
        return (new static())->setDelete();
    }

    public static function createSave()
    {
        return (new static())->setSave();
    }

    public static function createCreate()
    {
        return (new static())->setCreate();
    }
}

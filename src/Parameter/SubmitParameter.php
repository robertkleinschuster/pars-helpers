<?php

namespace Pars\Helper\Parameter;

class SubmitParameter extends AbstractParameter
{
    public const ATTRIBUTE_MODE = 'mode';
    public const MODE_CREATE = 'create';
    public const MODE_CREATE_BULK = 'create_bulk';
    public const MODE_SAVE = 'save';
    public const MODE_SAVE_BULK = 'save_bulk';
    public const MODE_DELETE = 'delete';
    public const MODE_DELETE_BULK = 'delete_bulk';

    /**
     * @return string
     */
    public static function name(): string
    {
        return 'submit';
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
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setCreate()
    {
        $this->setMode(self::MODE_CREATE);
        return $this;
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setDelete()
    {
        $this->setMode(self::MODE_DELETE);
        return $this;
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setSave()
    {
        $this->setMode(self::MODE_SAVE);
        return $this;
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setCreateBulk()
    {
        $this->setMode(self::MODE_CREATE_BULK);
        return $this;
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setDeleteBulk()
    {
        $this->setMode(self::MODE_DELETE_BULK);
        return $this;
    }

    /**
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setSaveBulk()
    {
        $this->setMode(self::MODE_SAVE_BULK);
        return $this;
    }

    /**
     * @return SubmitParameter
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public static function delete()
    {
        return (new static())->setDelete();
    }

    /**
     * @return SubmitParameter
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public static function save()
    {
        return (new static())->setSave();
    }

    /**
     * @return SubmitParameter
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public static function create()
    {
        return (new static())->setCreate();
    }

    /**
     * @return SubmitParameter
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public static function deleteBulk()
    {
        return (new static())->setDeleteBulk();
    }

    /**
     * @return SubmitParameter
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public static function saveBulk()
    {
        return (new static())->setSaveBulk();
    }

    /**
     * @return SubmitParameter
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public static function createBulk()
    {
        return (new static())->setCreateBulk();
    }
}

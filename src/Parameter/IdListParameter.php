<?php


namespace Pars\Helper\Parameter;


use Pars\Pattern\Exception\AttributeExistsException;
use Pars\Pattern\Exception\AttributeLockException;
use Pars\Pattern\Exception\AttributeNotFoundException;

/**
 * Class IdListParameter
 * @package Pars\Helper\Parameter
 */
class IdListParameter extends AbstractParameter
{

    /**
     * @param string $field
     * @param null $value
     * @return IdListParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function addId(string $field, $value = null): self
    {
        if (null === $value) {
            $value = "{{$field}}";
        }
        $this->setAttribute($field, (string)$value);
        return $this;
    }

    /**
     * @param array $id_Map
     * @return IdListParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function addId_Map(array $id_Map): self
    {
        foreach ($id_Map as $key => $value) {
            if (is_string($key)) {
                $this->addId($key, $value);
            } else {
                $this->addId($value);
            }
        }
        return $this;
    }

    /***
     * @param array|string $data
     * @return AbstractParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function fromData($data): AbstractParameter
    {
        foreach ($data as $datum) {
            parent::fromData($datum);
        }
        return $this;
    }

    /**
     * @param array $parameter
     * @return AbstractParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     * @throws AttributeNotFoundException
     */
    public function fromArray(array $parameter): AbstractParameter
    {
        foreach ($parameter as $key => $value) {
            $data = $this->getAttribute($key, true, []);
            $data[] = $value;
            $this->setAttribute($key, $data);
        }
        return $this;
    }


    /**
     * @param bool $asArr
     * @return string
     */
    public static function name(bool $asArr = true): string
    {
        if ($asArr) {
            return 'id_list[]';
        } else {
            return 'id_list';
        }
    }

    /**
     * @param array $id_Map
     * @return IdListParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public static function fromMap(array $id_Map): self
    {
        return (new static())->addId_Map($id_Map);
    }

}

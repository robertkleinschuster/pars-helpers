<?php

namespace Pars\Helper\Parameter;

/**
 * Class IdParameter
 * @package Pars\Helper\Parameter
 */
class IdParameter extends AbstractParameter
{
    /**
     * @param string $field
     * @param $value
     */
    public function addId(string $field, $value = null)
    {
        if (null === $value) {
            $value = "{{$field}}";
        }
        $this->setAttribute($field, (string)$value);
        return $this;
    }

    /**
     * @param array $id_Map
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

    public static function name(): string
    {
        return 'id';
    }

    /**
     * @param array $id_Map
     * @return IdParameter
     */
    public static function createFromMap(array $id_Map)
    {
        return (new static)->addId_Map($id_Map);
    }
}

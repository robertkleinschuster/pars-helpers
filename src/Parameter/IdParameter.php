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

    public static function name(): string
    {
        return 'id';
    }
}

<?php


namespace Pars\Helper\Parameter;


class DataParameter extends AbstractParameter
{

    public static function name(): string
    {
        return 'data';
    }

    public function fromArray(array $parameter): AbstractParameter
    {
        foreach ($parameter as $key => $value) {
            $this->setAttribute($key, urldecode($value));
        }
        return $this;
    }
}

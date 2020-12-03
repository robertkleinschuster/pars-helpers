<?php


namespace Pars\Helper\Parameter;


class IdListParameter extends AbstractParameter
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

    public function fromData($data): AbstractParameter
    {
        foreach ($data as $datum) {
            parent::fromData($datum);
        }
        return $this;
    }

    public function fromArray(array $parameter): AbstractParameter
    {
        foreach ($parameter as $key => $value) {
            $data = $this->getAttribute($key, true, []);
            $data[] = $value;
            $this->setAttribute($key, $data);
        }
        return $this;
    }


    public static function name(bool $asArr = true): string
    {
        if ($asArr) {
            return 'id_list[]';
        } else {
            return 'id_list';
        }
    }

}

<?php

namespace Pars\Helper\Parameter;

class ParameterMapHelper
{
    /**
     * @param string $parameter
     * @return array
     */
    public function parseParameter(string $parameter): array
    {
        $result = [];
        $key_List = explode(';', $parameter);
        foreach ($key_List as $item) {
            $split = explode(':', $item);
            if (!empty($split[0]) && !empty($split[1])) {
                $result[$split[0]] = $split[1];
            }
        }
        return $result;
    }

    /**
     * @param array $data_Map
     * @return string
     */
    public function generateParameter(array $data_Map): string
    {
        $result = [];
        foreach ($data_Map as $key => $value) {
            if (empty($value)) {
                $result[] = "$key";
            } else {
                $result[] = "$key:$value";
            }
        }
        return implode(';', $result);
    }
}

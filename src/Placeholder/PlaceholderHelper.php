<?php


namespace Pars\Helper\Placeholder;


use Pars\Bean\Converter\ConverterBeanDecorator;
use Pars\Bean\Type\Base\BeanInterface;

class PlaceholderHelper
{
    /**
     * @param string $str
     * @param BeanInterface $bean
     * @return string
     */
    public function replacePlaceholder(string $str, BeanInterface $bean): string
    {
        $matches = self::findPlaceholder($str);
        $keys = [];
        $values = [];
        $this->replacePlaceholderValues($matches, $str, $bean, $keys, $values);
        return str_replace($keys, $values, $str);
    }

    /**
     * @param string $str
     * @return array
     */
    public static function findPlaceholder(string $str): array
    {
        $matches = [];
        preg_match_all('/\{.*?\}|%7B.*?%7D|%257B.*?%257D/', $str, $matches);
        return $matches;
    }

    /**
     * @param string $str
     * @return array
     */
    public static function findPlaceholderResolved(string $str): array
    {
        $result = [];
        $placeholders = self::findPlaceholder($str);
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($placeholders));
        foreach ($it as $value) {
            $result[$value] = self::removeDelimiter($value);
        }
        return $result;
    }

    public static function removeDelimiter(string $placeholder): string
    {
        $replace['{'] = '';
        $replace[urlencode('{')] = '';
        $replace[urlencode(urlencode('{'))] = '';
        $replace['}'] = '';
        $replace[urlencode('}')] = '';
        $replace[urlencode(urlencode('}'))] = '';
        return str_replace(array_keys($replace), array_values($replace), $placeholder);
    }

    /**
     * @param array $keys
     * @param string $subject
     * @param BeanInterface $bean
     * @param array $repkeys
     * @param array $repvalues
     */
    private function replacePlaceholderValues(
        array $keys,
        string &$subject,
        BeanInterface $bean,
        array &$repkeys,
        array &$repvalues
    )
    {
        foreach ($keys as $key) {
            if (is_array($key)) {
                $this->replacePlaceholderValues($key, $subject, $bean, $repkeys, $repvalues);
            } else {
                if (strpos($key, ' ') !== false) {
                    continue;
                }
                $value = $key;
                $name = $key;
                $name = str_replace('{', '', $name);
                $name = str_replace('}', '', $name);
                $name = str_replace('%7B', '', $name);
                $name = str_replace('%7D', '', $name);
                $name = str_replace('%257B', '', $name);
                $name = str_replace('%257D', '', $name);
                if ($bean->exists($name) && $bean->isset($name)) {
                    $value = $bean->get($name);
                } else {
                    $data = $this->unnormalizeArray($bean->toArray(true));
                    if (isset($data[$name])) {
                        $value = $data[$name];
                    } else {
                        if ($bean instanceof ConverterBeanDecorator) {
                            $data = $this->unnormalizeArray($bean->toBean()->toArray(true));
                            if (isset($data[$name])) {
                                $value = $data[$name];
                            }
                        }
                    }
                }
                if (is_string($value)) {
                    $repkeys[] = "{{$name}}";
                    $repkeys[] = "%7B{$name}%7D";
                    $repkeys[] = "%257B{$name}%257D";
                    $repvalues[] = $value;
                    $repvalues[] = urlencode($value);
                    $repvalues[] = urlencode(urlencode($value));
                } else {
                    $repkeys[] = "{{$name}}";
                    $repkeys[] = "%7B{$name}%7D";
                    $repkeys[] = "%257B{$name}%257D";
                    $repvalues[] = "$name not string";
                    $repvalues[] = "$name not string";
                    $repvalues[] = "$name not string";
                }
            }
        }
    }

    /**
     * @param array $data
     * @param string|null $name
     * @return array
     */
    private function unnormalizeArray(array $data, string $name = null)
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (null !== $name) {
                $arrKey = "{$name}[$key]";
            } else {
                $arrKey = $key;
            }
            if (is_array($value)) {
                $result = array_replace($result, $this->unnormalizeArray($value, $arrKey));
            } else {
                $result[$arrKey] = $value;
            }
        }
        return $result;
    }

}

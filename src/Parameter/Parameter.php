<?php


namespace Pars\Helper\Parameter;


class Parameter extends AbstractParameter
{
    protected static string $name = '';

    /**
     * Parameter constructor.
     * @param string $name
     */
    public function __construct(string $name, string $value)
    {
        self::$name = $name;
        $this->setAttribute($value, '');
    }

    public static function name(): string
    {
        return self::$name;
    }


}

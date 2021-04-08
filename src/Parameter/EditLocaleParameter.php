<?php


namespace Pars\Helper\Parameter;


class EditLocaleParameter extends AbstractParameter
{
    protected static string $name = 'editlocale';

    /**
     * Parameter constructor.
     * @param string $value
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function __construct(string $value)
    {
        $this->setAttribute($value, '');
    }

    public static function name(): string
    {
        return self::$name;
    }


}

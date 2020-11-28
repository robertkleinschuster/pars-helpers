<?php

namespace Pars\Helper\Parameter;

class RedirectParameter extends AbstractParameter
{
    public const ATTRIBUTE_PATH = 'path';


    public static function name(): string
    {
        return 'redirect';
    }


    /**
     * @param string $path
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setPath(string $path)
    {
        $this->setAttribute(self::ATTRIBUTE_PATH, $path);
        return $this;
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getPath(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_PATH);
    }
}

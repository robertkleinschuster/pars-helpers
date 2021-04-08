<?php

namespace Pars\Helper\Parameter;

use Pars\Pattern\Exception\AttributeExistsException;
use Pars\Pattern\Exception\AttributeLockException;
use Pars\Pattern\Exception\AttributeNotFoundException;

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
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public function setPath(string $path)
    {
        $this->setAttribute(self::ATTRIBUTE_PATH, $path);
        return $this;
    }

    /**
     * @return string
     * @throws AttributeNotFoundException
     */
    public function getPath(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_PATH);
    }

    /**
     * @param string $path
     * @return RedirectParameter
     * @throws AttributeExistsException
     * @throws AttributeLockException
     */
    public static function fromPath(string $path): self
    {
        return (new static())->setPath($path);
    }
}

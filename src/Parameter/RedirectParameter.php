<?php

namespace Pars\Helper\Parameter;

class RedirectParameter extends AbstractParameter
{
    public const ATTRIBUTE_LINK = 'link';


    public static function getParameterKey(): string
    {
        return 'redirect';
    }


    /**
     * @param string $link
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setLink(string $link)
    {
        $this->setAttribute(self::ATTRIBUTE_LINK, urlencode($link));
        return $this;
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getLink(): string
    {
        return urldecode($this->getAttribute(self::ATTRIBUTE_LINK));
    }
}

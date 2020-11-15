<?php

namespace Pars\Helper\Parameter;

class SearchParameter extends AbstractParameter
{
    public const ATTRIBUTE_TEXT = 'text';

    public static function getParameterKey(): string
    {
        return 'search';
    }


    /**
     * @return string
     */
    public static function getFormKeyText()
    {
        return self::getFormKey(self::ATTRIBUTE_TEXT);
    }

    /**
     * @param string $text
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setText(string $text)
    {
        $this->setAttribute(self::ATTRIBUTE_TEXT, $text);
        return $this;
    }

    /**
     * @return string
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getText(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_TEXT);
    }
}

<?php

namespace Pars\Helper\Parameter;

class SearchParameter extends AbstractParameter
{
    public const ATTRIBUTE_TEXT = 'text';

    public static function name(): string
    {
        return 'search';
    }


    /**
     * @return string
     */
    public static function getFormKeyText()
    {
        return self::nameAttr(self::ATTRIBUTE_TEXT);
    }

    /**
     * @param string $text
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function setText(string $text)
    {
        $this->setAttribute(self::ATTRIBUTE_TEXT, $text);
        return $this;
    }

    /**
     * @return string
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function getText(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_TEXT);
    }

    /**
     * @return bool
     */
    public function hasText(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_TEXT);
    }
}

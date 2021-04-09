<?php


namespace Pars\Helper\Parameter;

/**
 * Class ContextParameter
 * @package Pars\Helper\Parameter
 */
class ContextParameter extends RedirectParameter
{
    public const ATTRIBUTE_TITLE = 'title';

    public static function name(): string
    {
        return 'context';
    }

    public function hasTitle(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_TITLE);
    }

    public function getTitle(): string
    {
        return $this->getAttribute(self::ATTRIBUTE_TITLE);
    }

    public function setTitle(string $title): self
    {
        $this->setAttribute(self::ATTRIBUTE_TITLE, $title);
        return $this;
    }

    /**
     * @param $path
     * @return ContextParameter[]
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function resolveContextFromPath(string $path = null): array
    {
        $result = [];

        if (null === $path) {
            $path = $this->getPath();
            $result[] = $this;
        }
        do {
            $context = null;
            $url = parse_url($path);
            if (isset($url['query'])) {
                $get = [];
                parse_str($url['query'], $get);
                if (isset($get[self::name()])) {
                    $context = new ContextParameter();
                    $context->fromData($get[self::name()]);
                }
            }
            if ($context) {
                $result[] = $context;
                $path = $context->getPath();
            }
        } while ($context);

        return array_reverse($result);
    }
}

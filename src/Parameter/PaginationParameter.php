<?php

namespace Pars\Helper\Parameter;

class PaginationParameter extends AbstractParameter
{

    public const ATTRIBUTE_PAGE = 'page';
    public const ATTRIBUTE_LIMIT = 'limit';

    /**
     * PaginationParameter constructor.
     * @param int|null $page
     * @param int|null $limit
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function __construct(int $page = null, int $limit = null)
    {
        if ($page) {
            $this->setPage($page);
        }
        if ($limit) {
            $this->setLimit($limit);
        }
    }


    public static function name(): string
    {
        return 'pagination';
    }


    /**
     * @param int $page
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setPage(int $page)
    {
        $this->setAttribute(self::ATTRIBUTE_PAGE, (string)$page);
        return $this;
    }

    /**
     * @return int
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getPage(): int
    {
        return (int)$this->getAttribute(self::ATTRIBUTE_PAGE);
    }

    /**
     * @param int $limit
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setLimit(int $limit)
    {
        $this->setAttribute(self::ATTRIBUTE_LIMIT, (string)$limit);
        return $this;
    }

    /**
     * @return int
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getLimit(): int
    {
        return (int)$this->getAttribute(self::ATTRIBUTE_LIMIT);
    }

    /**
     * @return bool
     */
    public function hasLimit(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_LIMIT);
    }

    /**
     * @return bool
     */
    public function hasPage(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_PAGE);
    }
}

<?php

namespace Pars\Helper\Parameter;

class PaginationParameter extends AbstractParameter
{

    public const ATTRIBUTE_PAGE = 'page';
    public const ATTRIBUTE_LIMIT = 'limit';


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
        $this->setAttribute(self::ATTRIBUTE_PAGE, (string) $page);
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     * @throws \Niceshops\Core\Exception\AttributeExistsException
     * @throws \Niceshops\Core\Exception\AttributeLockException
     */
    public function setLimit(int $limit)
    {
        $this->setAttribute(self::ATTRIBUTE_LIMIT, (string) $limit);
        return $this;
    }

    /**
     * @return int
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getPage(): int
    {
        return (int) $this->getAttribute(self::ATTRIBUTE_PAGE);
    }

    /**
     * @return int
     * @throws \Niceshops\Core\Exception\AttributeNotFoundException
     */
    public function getLimit(): int
    {
        return (int) $this->getAttribute(self::ATTRIBUTE_LIMIT);
    }
}

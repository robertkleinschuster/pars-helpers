<?php

declare(strict_types=1);

namespace Pars\Helper\Path;

/**
 * Interface PathHelperAwareInterface
 * @package Pars\Helper\Helper
 */
interface PathHelperAwareInterface
{
    /**
     * @return PathHelper
     */
    public function getPathHelper(bool $reset = true): PathHelper;

    /**
     * @param PathHelper $pathHelper
     *
     * @return $this
     */
    public function setPathHelper(PathHelper $pathHelper);

    /**
     * @return bool
     */
    public function hasPathHelper(): bool;
}

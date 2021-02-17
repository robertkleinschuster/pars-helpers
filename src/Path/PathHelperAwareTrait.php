<?php

declare(strict_types=1);

namespace Pars\Helper\Path;


/**
 * Trait PathHelperAwareTrait
 * @package Pars\Helper\Helper
 */
trait PathHelperAwareTrait
{
    private ?PathHelper $pathHelper = null;

    /**
     * @param bool $reset
     * @return PathHelper
     */
    public function getPathHelper(bool $reset = true): PathHelper
    {
        $helper = clone $this->pathHelper;
        if ($reset) {
            $helper->reset();
        }
        return $helper;
    }

    /**
     * @param PathHelper $pathHelper
     *
     * @return $this
     */
    public function setPathHelper(PathHelper $pathHelper)
    {
        $this->pathHelper = $pathHelper;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasPathHelper(): bool
    {
        return $this->pathHelper !== null;
    }
}

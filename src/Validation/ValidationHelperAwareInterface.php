<?php

declare(strict_types=1);

namespace Pars\Helper\Validation;

/**
 * Interface ValidationHelperAwareInterface
 * @package Pars\Helper\Helper
 */
interface ValidationHelperAwareInterface
{
    public function getValidationHelper(): ValidationHelper;
}

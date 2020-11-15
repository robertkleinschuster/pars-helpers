<?php

declare(strict_types=1);

namespace Pars\Helper\Validation;

/**
 * Trait ValidationHelperAwareTrait
 * @package Pars\Helper\Helper
 */
trait ValidationHelperAwareTrait
{

    /**
     * @var ValidationHelper
     */
    private ?ValidationHelper $validationHelper = null;

    /**
     * @return ValidationHelper
     */
    public function getValidationHelper(): ValidationHelper
    {
        if ($this->validationHelper === null) {
            $this->validationHelper = new ValidationHelper();
        }
        return $this->validationHelper;
    }
}

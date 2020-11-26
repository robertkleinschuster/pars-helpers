<?php

declare(strict_types=1);

namespace Pars\Helper\Validation;

/**
 * Class ValidationHelper
 * @package Pars\Helper\Helper
 */
class ValidationHelper
{
    /**
     * @var string[]
     */
    private $errorField_Map;

    /**
     * ValidationHelper constructor.
     */
    public function __construct()
    {
        $this->errorField_Map = [];
    }

    /**
     * @param string $field
     * @param string $error
     * @return ValidationHelper
     */
    public function addError(string $field, string $error): self
    {
        $this->errorField_Map[$field][] = $error;
        return $this;
    }

    /**
     * @param string|null $field
     * @return bool
     */
    public function hasError(string $field = null): bool
    {
        if ($field) {
            return isset($this->errorField_Map[$field]);
        } else {
            return count($this->errorField_Map) > 0;
        }
    }

    /**
     * @param string $field
     * @return array
     */
    public function getErrorList(string $field = null): array
    {
        if (null === $field) {
            $errors = [];
            foreach ($this->errorField_Map as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $errors[] = $error;
                }
            }
            return $errors;
        } else {
            return $this->errorField_Map[$field] ?? [];
        }
    }

    /**
     * @param string|null $field
     * @return string
     */
    public function getSummary(string $field = null, bool $html = true): string
    {
        $errors = $this->getErrorList($field);
        if ($html) {
            return implode('<br>', $errors);
        } else {
            return implode(PHP_EOL, $errors);
        }
    }

    /**
     * @return string[]
     */
    public function getErrorFieldMap(): array
    {
        return $this->errorField_Map;
    }

    /**
     * @param array $errorField_Map
     * @return ValidationHelper
     */
    public function addErrorFieldMap(array $errorField_Map)
    {
        $this->errorField_Map = array_merge_recursive($this->errorField_Map, $errorField_Map);
        return $this;
    }

    /**
     * @param ValidationHelper $validationHelper
     * @return $this
     */
    public function merge(ValidationHelper $validationHelper)
    {
        $this->addErrorFieldMap($validationHelper->getErrorFieldMap());
        return $this;
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        $result = [];
        foreach ($this->errorField_Map as $fieldErrorList) {
            $result[] = implode(PHP_EOL, $fieldErrorList);
        }
        return implode(PHP_EOL, $result);
    }
}

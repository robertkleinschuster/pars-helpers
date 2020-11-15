<?php

namespace Pars\Helper\Parameter;

/**
 * Interface ParameterListAwareInterface
 * @package Pars\Helper\Parameter
 */
interface ParameterListAwareInterface
{
    /**
     * @return ParameterList
     */
    public function getParameterList(): ParameterList;

    /**
     * @param ParameterList $parameterList
     *
     * @return $this
     */
    public function setParameterList(ParameterList $parameterList);

    /**
     * @return bool
     */
    public function hasParameterList(): bool;
}

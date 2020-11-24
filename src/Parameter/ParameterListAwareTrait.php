<?php

namespace Pars\Helper\Parameter;

trait ParameterListAwareTrait
{
    private ?ParameterList $parameterList = null;

    /**
    * @return ParameterList
    */
    public function getParameterList(): ParameterList
    {
        if (!$this->hasParameterList()) {
            $this->parameterList = new ParameterList();
        }
        return $this->parameterList;
    }

    /**
    * @param ParameterList $parameterList
    *
    * @return $this
    */
    public function setParameterList(ParameterList $parameterList)
    {
        $this->parameterList = $parameterList;
        return $this;
    }

    /**
    * @return bool
    */
    public function hasParameterList(): bool
    {
        return $this->parameterList !== null;
    }
}

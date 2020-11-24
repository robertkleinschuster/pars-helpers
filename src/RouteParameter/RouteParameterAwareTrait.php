<?php

namespace Pars\Helper\RouteParameter;

trait RouteParameterAwareTrait
{
    /**
     * @var RouteParameter|null
     */
    private ?RouteParameter $routeParameter = null;

    /**
     * @return RouteParameter
     */
    public function getRouteParameter(): RouteParameter
    {
        if (!$this->hasRouteParameter()) {
            $this->routeParameter = new RouteParameter();
        }
        return $this->routeParameter;
    }

    /**
     * @param RouteParameter $routeParameter
     *
     * @return $this
     */
    public function setRouteParameter(RouteParameter $routeParameter)
    {
        $this->routeParameter = $routeParameter;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasRouteParameter(): bool
    {
        return $this->routeParameter !== null;
    }
}

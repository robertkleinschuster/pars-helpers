<?php

namespace Pars\Helper\RouteParameter;

/**
 * Trait RouteParameterAwareInterface
 * @package Pars\Helper\RouteParameter
 */
interface RouteParameterAwareInterface
{

    /**
    * @return RouteParameter
    */
    public function getRouteParameter(): RouteParameter;

    /**
    * @param RouteParameter $routeParameter
    *
    * @return $this
    */
    public function setRouteParameter(RouteParameter $routeParameter);

    /**
    * @return bool
    */
    public function hasRouteParameter(): bool;
}

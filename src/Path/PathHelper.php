<?php

declare(strict_types=1);

namespace Pars\Helper\Path;

use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use Pars\Helper\Parameter\FilterParameter;
use Pars\Helper\Parameter\IdParameter;
use Pars\Helper\Parameter\OrderParameter;
use Pars\Helper\Parameter\ParameterInterface;
use Pars\Helper\Parameter\ParameterList;
use Pars\Helper\Parameter\ParameterListAwareInterface;
use Pars\Helper\Parameter\ParameterListAwareTrait;
use Pars\Helper\Parameter\SearchParameter;
use Pars\Helper\RouteParameter\RouteParameter;
use Pars\Helper\RouteParameter\RouteParameterAwareInterface;
use Pars\Helper\RouteParameter\RouteParameterAwareTrait;

/**
 * Class PathHelper
 * @package Pars\Helper\Helper
 */
class PathHelper implements ParameterListAwareInterface, RouteParameterAwareInterface
{
    use ParameterListAwareTrait;
    use RouteParameterAwareTrait;

    /**
     * @var UrlHelper
     */
    private UrlHelper $urlHelper;

    /**
     * @var ServerUrlHelper
     */
    private ServerUrlHelper $serverUrlHelper;

    /**
     * @var string
     */
    private ?string $routeName = null;

    /**
     * @var string|null
     */
    private ?string $fragment = null;

    /**
     * @var string|null
     */
    private ?string $currentPathReal = null;


    /**
     * Path constructor.
     * @param UrlHelper $urlHelper
     * @param ServerUrlHelper $serverUrlHelper
     */
    public function __construct(
        UrlHelper $urlHelper,
        ServerUrlHelper $serverUrlHelper
    )
    {
        $this->urlHelper = $urlHelper;
        $this->serverUrlHelper = $serverUrlHelper;
    }

    /**
     * @return UrlHelper
     */
    public function getUrlHelper(): UrlHelper
    {
        return $this->urlHelper;
    }

    /**
     * @return ServerUrlHelper
     */
    public function getServerUrlHelper(): ServerUrlHelper
    {
        return $this->serverUrlHelper;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->getRouteParameter()->getController();
    }

    /**
     * @param string $controller
     *
     * @return $this
     */
    public function setController(string $controller): self
    {
        $this->getRouteParameter()->setController($controller);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasController(): bool
    {
        return $this->getRouteParameter()->hasController();
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getRouteParameter()->getAction();
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction(string $action): self
    {
        $this->getRouteParameter()->setAction($action);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAction(): bool
    {
        return $this->getRouteParameter()->hasAction();
    }

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }

    /**
     * @param string $routeName
     *
     * @return $this
     */
    public function setRouteName(string $routeName): self
    {
        $this->routeName = $routeName;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasRouteName(): bool
    {
        return $this->routeName !== null;
    }

    /**
     * @param ParameterInterface $parameter
     * @return PathHelper
     */
    public function addParameter(ParameterInterface $parameter)
    {
        if (!$this->hasParameterList()) {
            $this->setParameterList(new ParameterList());
        }
        $this->getParameterList()->set($parameter);
        return $this;
    }

    /**
     * @param IdParameter $idParameter
     * @return $this
     */
    public function setId(IdParameter $idParameter)
    {
        $this->addParameter($idParameter);
        return $this;
    }

    /**
     * @return IdParameter
     */
    public function getId(): ParameterInterface
    {
        if (!$this->getParameterList()->has(IdParameter::name())) {
            $this->getParameterList()->set(new IdParameter());
        }
        return $this->getParameterList()->get(IdParameter::name());
    }

    /**
     * @return FilterParameter
     */
    public function getFilter(): ParameterInterface
    {
        if (!$this->getParameterList()->has(FilterParameter::name())) {
            $this->getParameterList()->set(new FilterParameter());
        }
        return $this->getParameterList()->get(FilterParameter::name());
    }

    /**
     * @return FilterParameter
     */
    public function getSearch(): ParameterInterface
    {
        if (!$this->getParameterList()->has(SearchParameter::name())) {
            $this->getParameterList()->set(new SearchParameter());
        }
        return $this->getParameterList()->get(SearchParameter::name());
    }

    /**
     * @return FilterParameter
     */
    public function getOrder(): ParameterInterface
    {
        if (!$this->getParameterList()->has(OrderParameter::name())) {
            $this->getParameterList()->set(new OrderParameter());
        }
        return $this->getParameterList()->get(OrderParameter::name());
    }

    /**
     * @return $this
     */
    public function resetId()
    {
        $this->getParameterList()->unset(IdParameter::name());
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function addRouteParameter(string $key, string $value)
    {
        if (!$this->hasRouteParameter()) {
            $this->setRouteParameter(new RouteParameter());
        }
        $this->getRouteParameter()->setAttribute($key, $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    /**
     * @param string $fragment
     *
     * @return $this
     */
    public function setFragment(string $fragment): self
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasFragment(): bool
    {
        return isset($this->fragment);
    }


    /**
     * @return $this
     */
    public function reset(): self
    {
        $this->routeName = null;
        $this->fragment = null;
        $this->setRouteParameter(new RouteParameter());
        $this->setParameterList(new ParameterList());
        return $this;
    }

    /**
     * @param bool $reset
     * @return string
     */
    public function getPath(bool $reset = false): string
    {
        if ($this->hasRouteName()) {
            $routeName = $this->getRouteName();
        } else {
            $routeName = null;
        }
        $path = $this->getUrlHelper()->generate(
            $routeName,
            $this->getRouteParameter()->getAttribute_List(),
            $this->getParameterList()->toArray(),
            $this->getFragment()
        );
        if ($reset) {
            $this->reset();
        }
        return $path;
    }

    /**
     * @param bool $reset
     * @return string
     */
    public function getServerPath(bool $reset = false): string
    {
        return $this->getServerUrlHelper()->generate($this->getPath($reset));
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->getServerUrlHelper()->generate($this->getUrlHelper()->getBasePath());
    }

    public function __toString()
    {
        return $this->getPath();
    }


    /**
     * @return PathHelper
     */
    public function clone(): self
    {
        return clone $this;
    }

    public function __clone()
    {
        if ($this->hasRouteParameter()) {
            $this->routeParameter = clone $this->routeParameter;
        }
        if ($this->hasParameterList()) {
            $parameterList = new ParameterList();
            foreach ($this->getParameterList() as $item) {
                $parameterList->set(clone $item);
            }
            $this->parameterList = $parameterList;
        }
        $this->urlHelper = clone $this->urlHelper;
        $this->serverUrlHelper = clone $this->serverUrlHelper;
    }

    /**
    * @return string
    */
    public function getCurrentPathReal(): string
    {
        return $this->currentPathReal;
    }

    /**
    * @param string $currentPathReal
    *
    * @return $this
    */
    public function setCurrentPathReal(string $currentPathReal): self
    {
        $this->currentPathReal = $currentPathReal;
        return $this;
    }

    /**
    * @return bool
    */
    public function hasCurrentPathReal(): bool
    {
        return isset($this->currentPathReal);
    }

}

<?php

namespace Pars\Helper\Path;

use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class BasePathMiddlewareDecorator implements MiddlewareInterface
{
    /** @var MiddlewareInterface */
    private $middleware;

    /** @var string BasePath name under which the middleware is segregated.  */
    private $path;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * BasePathMiddlewareDecorator constructor.
     * @param string $path
     * @param MiddlewareInterface $middleware
     * @param UrlHelper $urlHelper
     */
    public function __construct(string $path, MiddlewareInterface $middleware, UrlHelper $urlHelper)
    {
        $this->path = $path;
        $this->middleware = $middleware;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->urlHelper->setBasePath($this->path);
        $pathMiddleware = new PathMiddlewareDecorator($this->path, $this->middleware);
        return $pathMiddleware->process($request, $handler);
    }
}

/**
 * @param string $basPath
 * @param MiddlewareInterface $middleware
 * @param UrlHelper $urlHelper
 * @return BasePathMiddlewareDecorator
 */
function basepath(string $basPath, MiddlewareInterface $middleware, UrlHelper $urlHelper): BasePathMiddlewareDecorator
{
    return new BasePathMiddlewareDecorator($basPath, $middleware, $urlHelper);
}

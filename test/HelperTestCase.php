<?php


namespace ParsTest\Helper;


use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route;
use Mezzio\Router\RouteResult;
use Pars\Helper\Path\PathHelper;
use Pars\Pattern\PHPUnit\DefaultTestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class HelperTestCase
 * @package ParsTest\Helper
 */
class HelperTestCase extends DefaultTestCase
{
    /**
     * @return PathHelper
     */
    protected function getPathHelper(): PathHelper
    {
        $route = new Route('{controller}/{action}', new class() implements MiddlewareInterface {
            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                return $handler->handle($request);
            }
        });
        $router = new FastRouteRouter();
        $request = new ServerRequest([], [], new Uri('test/test'));
        $router->addRoute($route);
        $router->match($request);
        $urlHelper = new UrlHelper($router);
        $result = RouteResult::fromRoute($route);
        $urlHelper->setRouteResult($result);
        $path = new PathHelper($urlHelper, new ServerUrlHelper());
        $path->setController('test');
        $path->setAction('test');
        return $path;
    }
}

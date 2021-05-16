<?php

declare(strict_types=1);

/**
 * @see       https://github.com/niceshops/nice-beans for the canonical source repository
 * @license   https://github.com/niceshops/nice-beans/blob/master/LICENSE BSD 3-Clause License
 */

namespace ParsTest\Helper\Parameter;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route;
use Mezzio\Router\RouteResult;
use Pars\Helper\Parameter\ContextParameter;
use Pars\Helper\Path\PathHelper;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class DefaultTestCaseTest
 * @package Pars\Bean
 */
class ContextParameterTest extends \Pars\Pattern\PHPUnit\DefaultTestCase
{


    /**
     * @var ContextParameter|MockObject
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp(): void
    {
        $this->object = new ContextParameter();
    }


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }


    /**
     * @group integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(ContextParameter::class), "Class Exists");
        $this->assertTrue(is_a($this->object, ContextParameter::class), "Mock Object is set");
    }

    /**
     * @group unit
     * @small
     * @covers \Pars\Helper\Parameter\ContextParameter::resolveContextFromPath
     */
    public function testResolveContextFromPath()
    {
        $expect = [];
        $prev = new ContextParameter();
        for ($i = 1; $i < 10; $i++) {
            $context = new ContextParameter();
            $context->setTitle('title-' . $i);
            $context->setPath(
                $this->getPathHelper()
                    ->setController('path')
                    ->setAction('' . $i)
                    ->addParameter($prev)
                    ->getPath()
            );
            $prev = $context;
            $expect[] = $context;
        }
        $context = $prev;

        $path = $this->getPathHelper()
            ->setController('path')
            ->setAction('' . $i)
            ->addParameter($context)
            ->getPath();
        $this->assertEquals($expect, $context->resolveContextFromPath($path));
    }

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

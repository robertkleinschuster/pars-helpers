<?php

/**
 * @see       https://github.com/laminas/laminas-stratigility for the canonical source repository
 * @copyright https://github.com/laminas/laminas-stratigility/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-stratigility/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Pars\Helper\Path;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function strtolower;

final class SubDomainMiddlewareDecorator implements MiddlewareInterface
{
    /** @var MiddlewareInterface */
    private $middleware;

    /** @var string Host name under which the middleware is segregated. */
    private $subdomain;

    public function __construct(string $subdomain, MiddlewareInterface $middleware)
    {
        $this->subdomain = $subdomain;
        $this->middleware = $middleware;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $host = $request->getUri()->getHost();
        $exp = explode('.', $host);
        if ($exp[0] !== strtolower($this->subdomain)) {
            return $handler->handle($request);
        }
        return $this->middleware->process($request, $handler);
    }
}

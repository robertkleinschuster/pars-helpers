<?php

declare(strict_types=1);

namespace Pars\Helper\Helper;

use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

/**
 * Class PathHelperFactory
 * @package Pars\Helper\Helper
 */
class PathHelperFactory
{
    /**
     * @param ContainerInterface $container
     * @return PathHelper
     */
    public function __invoke(ContainerInterface $container): PathHelper
    {
        return new PathHelper(
            $container->get(UrlHelper::class),
            $container->get(ServerUrlHelper::class)
        );
    }
}

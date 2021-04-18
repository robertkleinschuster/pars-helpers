<?php

namespace Pars\Helper;

use Pars\Helper\Path\PathHelper;
use Pars\Helper\Path\PathHelperFactory;

class ConfigProvider
{


    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'bundles' => []
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases' => [
            ],
            'factories' => [
                PathHelper::class => PathHelperFactory::class
            ],
            'delegators' => [
            ],
        ];
    }
}

<?php
namespace Pars\Helper;

use Pars\Helper\Path\PathHelperFactory;
use Pars\Helper\Path\PathHelper;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies()
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

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
            'bundles' => [
                'entrypoints' => [
                    'helper'
                ],
                'list' => [
                    [
                        'type' => 'js-sw',
                        'output' => "helper-sw.js",
                        'sources' => [
                            __DIR__ . '/../bundles/js/sw.js',
                        ]
                    ],
                    [
                        'type' => 'js',
                        'output' => "helper.js",
                        'sources' => [
                            __DIR__ . '/../bundles/js/_closest.polyfill.js',
                            __DIR__ . '/../bundles/js/main.js',
                            #__DIR__ . '/../bundles/js/element.js',
                            __DIR__ . '/../bundles/js/path.js',
                        ]
                    ]
                ]
            ]
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

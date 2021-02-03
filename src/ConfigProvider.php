<?php

namespace Pars\Helper;

use Pars\Helper\Path\PathHelper;
use Pars\Helper\Path\PathHelperFactory;

class ConfigProvider
{
    protected static $hash = '';

    public static function hash() {
        if (self::$hash == '') {
            self::$hash = md5(random_bytes(5));
        }
        return self::$hash;
    }


    public function __invoke()
    {
        $hash = self::hash();
        return [
            'dependencies' => $this->getDependencies(),
            'bundles' => [
                'list' => [
                    [
                        'type' => 'js',
                        'output' => "helper-bundle_$hash.js",
                        'unlink' => "helper-bundle_*.js",
                        'sources' => [
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

<?php
/**
 * Slim Framework (https://slimframework.com)
 *
 * @link      https://github.com/slimphp/Slim
 * @copyright Copyright (c) 2011-2017 Josh Lockhart
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */
namespace Slim;

/**
 * Slim's default Service Provider.
 */
class DefaultServicesProvider
{
    /**
     * Register Slim's default services.
     *
     * @param Container $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register($container)
    {
        if (!isset($container['db'])) {
            $container['db'] = function ($container) {
                $capsule = new \Illuminate\Database\Capsule\Manager;
                $capsule->addConnection($container['settings']['db']);
                $capsule->setAsGlobal();
                $capsule->bootEloquent();
                return $capsule;
            };
        }
    }
}

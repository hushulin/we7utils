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
        // Laravel database
        if (!isset($container['db'])) {
            $container['db'] = function ($container) {
                $capsule = new \Illuminate\Database\Capsule\Manager;
                $capsule->addConnection($container['settings']['db']);
                $capsule->setAsGlobal();
                $capsule->bootEloquent();
                return $capsule;
            };
        }

        // Encryption system
        if ( !isset($container['encryption']) ) {
            $container['encryption'] = function($container){
                $config = $container->get('settings')['encryption'];

                if (\Illuminate\Support\Str::startsWith($key = $config['key'], 'base64:')) {
                    $key = base64_decode(substr($key, 7));
                }

                return new \Illuminate\Encryption\Encrypter($key, $config['cipher']);

            };
        }

        // Logger
        if ( !isset($container['logger']) ) {
            $container['logger'] = function ($container) {
                $settings = $container->get('settings')['logger'];
                $logger = new \Monolog\Logger($settings['name']);
                $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
                $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

                return $logger;
            };
        }

        // Qrcode generator
        if ( ! isset($container['qrcode']) ) {
            $container['qrcode'] = function ($container)
            {
                return new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
            };
        }

    }
}

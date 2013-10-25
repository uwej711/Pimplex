<?php
namespace Pimplex\ServiceProvider;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Bridge\Monolog\Handler\DebugHandler;

class MonologServiceProvider
{
    public function register(\Pimple $container)
    {
        $container['logger'] = function () use ($container) {
            return $container['monolog'];
        };

        if ($bridge = class_exists('Symfony\Bridge\Monolog\Logger')) {
            $container['monolog.handler.debug'] = function () use ($container) {
                return new DebugHandler($container['monolog.level']);
            };
        }

        $container['monolog.logger.class'] = $bridge ? 'Symfony\Bridge\Monolog\Logger' : 'Monolog\Logger';

        $container['monolog'] = $container->share(function ($container) {
                $log = new $container['monolog.logger.class']($container['monolog.name']);

                $log->pushHandler($container['monolog.handler']);

                if ($container['debug'] && isset($container['monolog.handler.debug'])) {
                    $log->pushHandler($container['monolog.handler.debug']);
                }

                return $log;
            });

        $container['monolog.handler'] = function () use ($container) {
            return new StreamHandler($container['monolog.logfile'], $container['monolog.level']);
        };

        $container['monolog.level'] = function () {
            return Logger::DEBUG;
        };

        $container['monolog.name'] = 'container';
    }
}
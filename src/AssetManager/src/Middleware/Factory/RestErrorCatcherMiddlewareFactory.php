<?php
declare(strict_types=1);

namespace AssetManager\Middleware\Factory;

use AssetManager\Middleware\RestErrorCatcherMiddleware;
use Psr\Container\ContainerInterface;

class RestErrorCatcherMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $middleware = new RestErrorCatcherMiddleware();

        return $middleware;
    }
}

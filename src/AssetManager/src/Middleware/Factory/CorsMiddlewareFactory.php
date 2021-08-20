<?php
declare(strict_types=1);

namespace AssetManager\Middleware\Factory;

use AssetManager\Middleware\CorsMiddleware;
use Psr\Container\ContainerInterface;

class CorsMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $middleware = new CorsMiddleware();

        return $middleware;
    }
}

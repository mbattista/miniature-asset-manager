<?php
declare(strict_types=1);

namespace AssetManager\Middleware\Factory;

use AssetManager\Middleware\LoginMiddleware;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;

class LoginMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $middleware = new LoginMiddleware();
        $middleware->setUser($container->get(User::class));

        return $middleware;
    }
}

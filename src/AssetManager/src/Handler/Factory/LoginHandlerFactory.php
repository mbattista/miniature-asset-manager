<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\LoginHandler;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new LoginHandler();
        $dash->setUser($container->get(User::class));

        return $dash;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\LogoutHandler;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new LogoutHandler();
        $dash->setUser($container->get(User::class));

        return $dash;
    }
}

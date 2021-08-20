<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetUserDetailHandler;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUserDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetUserDetailHandler();
        $dash->setUser($container->get(User::class));
        return $dash;
    }
}

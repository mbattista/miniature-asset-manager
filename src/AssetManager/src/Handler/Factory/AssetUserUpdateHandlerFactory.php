<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetUserUpdateHandler;
use AssetManager\Models\Person;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUserUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetUserUpdateHandler();
        $dash->setUser($container->get(User::class));
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

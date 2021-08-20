<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetUserCreateHandler;
use AssetManager\Models\Person;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUserCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetUserCreateHandler();
        $dash->setUser($container->get(User::class));
        $dash->setIssuer($container->get(User::class));
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

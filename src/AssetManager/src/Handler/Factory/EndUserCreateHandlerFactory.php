<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\EndUserCreateHandler;
use AssetManager\Models\Enduser;
use AssetManager\Models\Person;
use AssetManager\Models\Place;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new EndUserCreateHandler();
        $dash->setPerson($container->get(Person::class));
        $dash->setPlace($container->get(Place::class));
        $dash->setEndUser($container->get(Enduser::class));
        return $dash;
    }
}

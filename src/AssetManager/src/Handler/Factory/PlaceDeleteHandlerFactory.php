<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlaceDeleteHandler;
use AssetManager\Models\Place;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlaceDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlaceDeleteHandler();
        $dash->setPlace($container->get(Place::class));
        return $dash;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlaceDetailHandler;
use AssetManager\Models\Place;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlaceDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlaceDetailHandler();
        $dash->setPlace($container->get(Place::class));
        return $dash;
    }
}

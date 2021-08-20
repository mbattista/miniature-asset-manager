<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlaceUpdateHandler;
use AssetManager\Models\Citrix;
use AssetManager\Models\Place;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlaceUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlaceUpdateHandler();
        $dash->setPlace($container->get(Place::class));
        $dash->setCitrix($container->get(Citrix::class));
        return $dash;
    }
}

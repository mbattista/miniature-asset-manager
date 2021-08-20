<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlaceOverviewHandler;
use AssetManager\Models\Place;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlaceOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlaceOverviewHandler();
        $dash->setPlace($container->get(Place::class));
        return $dash;
    }
}

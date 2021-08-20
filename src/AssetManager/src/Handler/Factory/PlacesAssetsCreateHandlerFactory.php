<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlacesAssetsCreateHandler;
use AssetManager\Models\Asset;
use AssetManager\Models\Place;
use AssetManager\Models\PlacesAssets;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlacesAssetsCreateHandler();
        $dash->setPerson($container->get(User::class));
        $dash->setPlace($container->get(Place::class));
        $dash->setPlacesAssets($container->get(PlacesAssets::class));
        $dash->setAsset($container->get(Asset::class));

        return $dash;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlacesAssetsDetailHandler;
use AssetManager\Models\PlacesAssets;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlacesAssetsDetailHandler();
        $dash->setPlacesAssets($container->get(PlacesAssets::class));

        return $dash;
    }
}

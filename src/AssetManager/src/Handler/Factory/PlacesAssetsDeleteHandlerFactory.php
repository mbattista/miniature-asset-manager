<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlacesAssetsDeleteHandler;
use AssetManager\Models\PlacesAssets;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlacesAssetsDeleteHandler();
        $dash->setPlacesAssets($container->get(PlacesAssets::class));

        return $dash;
    }
}

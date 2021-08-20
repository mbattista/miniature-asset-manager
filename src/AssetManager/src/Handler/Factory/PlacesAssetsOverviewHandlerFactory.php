<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlacesAssetsOverviewHandler;
use AssetManager\Models\PlacesAssets;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlacesAssetsOverviewHandler();
        $dash->setPlacesAssets($container->get(PlacesAssets::class));

        return $dash;
    }
}

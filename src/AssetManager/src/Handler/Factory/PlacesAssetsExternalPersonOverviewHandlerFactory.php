<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PlacesAssetsExternalPersonOverviewHandler;
use AssetManager\Models\PlacesAssets;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsExternalPersonOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PlacesAssetsExternalPersonOverviewHandler();
        $dash->setPlacesAsset($container->get(PlacesAssets::class));

        return $dash;
    }
}

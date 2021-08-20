<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\ExternalPersonPlacesAssetsOverviewHandler;
use AssetManager\Models\PlacesAssets;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExternalPersonPlacesAssetsOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new ExternalPersonPlacesAssetsOverviewHandler();
        $dash->setPlacesAsset($container->get(PlacesAssets::class));

        return $dash;
    }
}

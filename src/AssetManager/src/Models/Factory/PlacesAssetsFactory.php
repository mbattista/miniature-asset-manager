<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\PlacesAssets;
use Psr\Container\ContainerInterface;

class PlacesAssetsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new PlacesAssets();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

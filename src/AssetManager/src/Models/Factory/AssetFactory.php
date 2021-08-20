<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\Asset;
use Psr\Container\ContainerInterface;

class AssetFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new Asset();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

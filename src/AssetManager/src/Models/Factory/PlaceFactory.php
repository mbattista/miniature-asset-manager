<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\Place;
use Psr\Container\ContainerInterface;

class PlaceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new Place();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

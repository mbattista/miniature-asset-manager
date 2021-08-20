<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\Enduser;
use Psr\Container\ContainerInterface;

class EndUserFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new Enduser();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

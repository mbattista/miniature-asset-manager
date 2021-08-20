<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\Citrix;
use Psr\Container\ContainerInterface;

class CitrixFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new Citrix();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

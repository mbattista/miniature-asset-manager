<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\Person;
use Psr\Container\ContainerInterface;

class PersonFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new Person();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

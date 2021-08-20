<?php
declare(strict_types=1);

namespace AssetManager\Models\Factory;

use AssetManager\Helper\DbHelper;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;

class UserFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $asset = new User();
        $asset->setDbHelper($container->get(DbHelper::class));

        return $asset;
    }
}

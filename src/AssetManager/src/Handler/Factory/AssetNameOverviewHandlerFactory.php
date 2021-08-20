<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetNameOverviewHandler;
use AssetManager\Models\Asset;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetNameOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetNameOverviewHandler();
        $dash->setAsset($container->get(Asset::class));
        return $dash;
    }
}

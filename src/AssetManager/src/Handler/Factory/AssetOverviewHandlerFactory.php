<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetOverviewHandler;
use AssetManager\Models\Asset;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetOverviewHandler();
        $dash->setAsset($container->get(Asset::class));
        return $dash;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetTypeOverviewHandler;
use AssetManager\Models\Asset;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetTypeOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetTypeOverviewHandler();
        $dash->setAsset($container->get(Asset::class));
        return $dash;
    }
}

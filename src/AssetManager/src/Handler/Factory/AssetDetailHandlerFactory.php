<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetDetailHandler;
use AssetManager\Models\Asset;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetDetailHandler();
        $dash->setAsset($container->get(Asset::class));
        return $dash;
    }
}

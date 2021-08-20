<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetDeleteHandler;
use AssetManager\Models\Asset;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetDeleteHandler();
        $dash->setAsset($container->get(Asset::class));
        return $dash;
    }
}

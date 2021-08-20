<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\AssetCreateHandler;
use AssetManager\Models\Asset;
use AssetManager\Models\Citrix;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new AssetCreateHandler();
        $dash->setAsset($container->get(Asset::class));
        $dash->setCitrix($container->get(Citrix::class));
        return $dash;
    }
}

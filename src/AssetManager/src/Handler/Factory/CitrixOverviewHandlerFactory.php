<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\CitrixOverviewHandler;
use AssetManager\Models\Citrix;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new CitrixOverviewHandler();
        $dash->setCitrix($container->get(Citrix::class));
        return $dash;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\EndUserOverviewHandler;
use AssetManager\Models\Enduser;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new EndUserOverviewHandler();
        $dash->setEndUser($container->get(Enduser::class));
        return $dash;
    }
}

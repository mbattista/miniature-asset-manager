<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\EndUserDetailHandler;
use AssetManager\Models\Enduser;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new EndUserDetailHandler();
        $dash->setEndUser($container->get(Enduser::class));
        return $dash;
    }
}

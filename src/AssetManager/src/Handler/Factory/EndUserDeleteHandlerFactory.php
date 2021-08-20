<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\EndUserDeleteHandler;
use AssetManager\Models\Enduser;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new EndUserDeleteHandler();
        $dash->setEndUser($container->get(Enduser::class));
        return $dash;
    }
}

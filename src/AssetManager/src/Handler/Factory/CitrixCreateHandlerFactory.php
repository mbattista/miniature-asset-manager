<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\CitrixCreateHandler;
use AssetManager\Models\Citrix;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new CitrixCreateHandler();
        $dash->setCitrix($container->get(Citrix::class));
        return $dash;
    }
}

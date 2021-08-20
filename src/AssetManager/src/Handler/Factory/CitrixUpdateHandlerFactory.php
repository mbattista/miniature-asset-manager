<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\CitrixUpdateHandler;
use AssetManager\Models\Citrix;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new CitrixUpdateHandler();
        $dash->setCitrix($container->get(Citrix::class));
        return $dash;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\CitrixDetailHandler;
use AssetManager\Models\Citrix;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new CitrixDetailHandler();
        $dash->setCitrix($container->get(Citrix::class));
        return $dash;
    }
}

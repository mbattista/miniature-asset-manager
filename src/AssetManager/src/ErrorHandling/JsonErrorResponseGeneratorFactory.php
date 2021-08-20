<?php
declare(strict_types=1);

namespace AssetManager\ErrorHandling;

use Psr\Container\ContainerInterface;

class JsonErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container) : JsonErrorResponseGenerator
    {
        $config = $container->has('config') ? $container->get('config') : [];

        $debug = $config['debug'] ?? false;

        return new JsonErrorResponseGenerator($debug);
    }
}
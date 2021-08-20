<?php
declare(strict_types=1);

namespace AssetManager\ErrorHandling;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ErrorHandler
    {
        $generator = $container->has(JsonErrorResponseGenerator::class)
            ? $container->get(JsonErrorResponseGenerator::class)
            : null;

        return new ErrorHandler($container->get(ResponseInterface::class), $generator);
    }
}

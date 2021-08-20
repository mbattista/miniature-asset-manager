<?php
declare(strict_types=1);

namespace AssetManager\ErrorHandling;

use Laminas\Log\PsrLoggerAdapter;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;

class LoggingErrorListenerDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback): ErrorHandler
    {
        $logger = $container->get('FileLogger');
        $listener = new LoggingErrorListener(new PsrLoggerAdapter($logger));

        /** @var ErrorHandler $errorHandler */
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);
        return $errorHandler;
    }
}

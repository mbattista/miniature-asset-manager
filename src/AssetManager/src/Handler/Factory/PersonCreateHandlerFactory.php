<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PersonCreateHandler;
use AssetManager\Models\Person;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PersonCreateHandler();
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

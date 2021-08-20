<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PersonDeleteHandler;
use AssetManager\Models\Person;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PersonDeleteHandler();
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

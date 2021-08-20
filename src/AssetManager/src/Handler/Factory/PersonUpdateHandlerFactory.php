<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PersonUpdateHandler;
use AssetManager\Models\Person;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PersonUpdateHandler();
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

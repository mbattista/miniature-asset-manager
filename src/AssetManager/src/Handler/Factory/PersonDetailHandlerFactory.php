<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PersonDetailHandler;
use AssetManager\Models\Person;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonDetailHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PersonDetailHandler();
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

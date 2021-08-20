<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PersonOverviewHandler;
use AssetManager\Models\Person;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PersonOverviewHandler();
        $dash->setPerson($container->get(Person::class));
        return $dash;
    }
}

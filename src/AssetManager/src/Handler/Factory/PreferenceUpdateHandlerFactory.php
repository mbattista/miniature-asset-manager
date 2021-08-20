<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\PreferenceUpdateHandler;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PreferenceUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new PreferenceUpdateHandler();
        $dash->setAssetUser($container->get(User::class));

        return $dash;
    }
}

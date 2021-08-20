<?php
declare(strict_types=1);

namespace AssetManager\Handler\Factory;

use AssetManager\Handler\SearchOverviewHandler;
use AssetManager\Models\Asset;
use AssetManager\Models\Citrix;
use AssetManager\Models\Enduser;
use AssetManager\Models\Place;
use AssetManager\Models\PlacesAssets;
use AssetManager\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SearchOverviewHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $dash = new SearchOverviewHandler();
        $dash->setPlacesAssets($container->get(PlacesAssets::class));
        $dash->setPlace($container->get(Place::class));
        $dash->setAsset($container->get(Asset::class));
        $dash->setEnduser($container->get(Enduser::class));
        $dash->setCitrix($container->get(Citrix::class));
        $dash->setUser($container->get(User::class));

        return $dash;
    }
}

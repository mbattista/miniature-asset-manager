<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Models\PlacesAssets;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsDetailHandler implements RequestHandlerInterface
{
    protected PlacesAssets $places_assets;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('places_assets');
        $this->getPlacesAssets()->get($id);

        return new JsonResponse($this->getPlacesAssets()->toArray());
    }

    /**
     * @return PlacesAssets
     */
    public function getPlacesAssets(): PlacesAssets
    {
        return $this->places_assets;
    }

    /**
     * @param PlacesAssets $places_assets
     * @return PlacesAssetsDetailHandler
     */
    public function setPlacesAssets(PlacesAssets $places_assets): PlacesAssetsDetailHandler
    {
        $this->places_assets = $places_assets;
        return $this;
    }
}

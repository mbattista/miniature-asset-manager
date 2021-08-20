<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\PlacesAssets;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExternalPersonPlacesAssetsOverviewHandler implements RequestHandlerInterface
{
    protected PlacesAssets $places_asset;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if (isset($request->getQueryParams()['q'])) {
            $search_term = $request->getQueryParams()['q'];
        } else {
            $search_term = null;
        }
        if (isset($request->getQueryParams()['per_page'])) {
            $per_page = (int)$request->getQueryParams()['per_page'];
        } else {
            $per_page = 25;
        }
        if (isset($request->getQueryParams()['page'])) {
            $offset = (int)$request->getQueryParams()['page'] * $per_page;
        } else {
            $offset = 0;
        }
        $data = $this->getPlacesAsset()->listByExternalPerson($offset, $per_page, $search_term);
        $total = $this->getPlacesAsset()->countByExternalPerson($search_term);
        $data['total'] = $total;

        return new JsonResponse($data);
    }

    /**
     * @return PlacesAssets
     */
    public function getPlacesAsset(): PlacesAssets
    {
        return $this->places_asset;
    }

    /**
     * @param PlacesAssets $places_asset
     * @return ExternalPersonPlacesAssetsOverviewHandler
     */
    public function setPlacesAsset(PlacesAssets $places_asset): ExternalPersonPlacesAssetsOverviewHandler
    {
        $this->places_asset = $places_asset;
        return $this;
    }
}

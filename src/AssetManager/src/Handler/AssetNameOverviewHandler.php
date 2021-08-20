<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\Asset;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetNameOverviewHandler implements RequestHandlerInterface
{
    protected Asset $asset;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if (isset($request->getQueryParams()['q'])) {
            $search_term = $request->getQueryParams()['q'];
            if (strpos(trim($search_term), ' ') !== false) {
                $search_term = str_replace(' ', '%', $search_term);
            }
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
        $data = $this->getAsset()->listAssetNames($offset, $per_page, $search_term);
        $total = $this->getAsset()->countNames($search_term);
        $data['total'] = $total;

        return new JsonResponse($data);
    }

    /**
     * @return Asset
     */
    public function getAsset(): Asset
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     * @return AssetNameOverviewHandler
     */
    public function setAsset(Asset $asset): AssetNameOverviewHandler
    {
        $this->asset = $asset;
        return $this;
    }
}

<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\Asset;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetOverviewHandler implements RequestHandlerInterface
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
        if (isset($request->getQueryParams()['order_by'])) {
            $order_by = $request->getQueryParams()['order_by'];
        } else {
            $order_by = null;
        }
        if (isset($request->getQueryParams()['sort'])) {
            $sort_direction = $request->getQueryParams()['sort'];
        } else {
            $sort_direction = null;
        }
        if (isset($request->getQueryParams()['show_inactive'])) {
            $show_inactive = $request->getQueryParams()['show_inactive'] === 'true';
        } else {
            $show_inactive = true;
        }
        $data = $this->getAsset()->listAssets($offset, $per_page, $search_term, $order_by, $sort_direction, $show_inactive);
        $total = $this->getAsset()->count($search_term, $show_inactive);
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
     * @return $this
     */
    public function setAsset(Asset $asset): AssetOverviewHandler
    {
        $this->asset = $asset;
        return $this;
    }
}

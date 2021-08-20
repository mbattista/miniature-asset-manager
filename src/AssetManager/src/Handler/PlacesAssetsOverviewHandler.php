<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Models\PlacesAssets;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsOverviewHandler implements RequestHandlerInterface
{
    protected PlacesAssets $places_assets;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     */
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

        if (isset($request->getQueryParams()['asset'])) {
            $asset = (int)$request->getQueryParams()['asset'];
        } else {
            $asset = null;
        }
        if (isset($request->getQueryParams()['place'])) {
            $place = (int)$request->getQueryParams()['place'];
        } else {
            $place = null;
        }
        if (isset($request->getQueryParams()['deliverer_person'])) {
            $deliverer_person = (int)$request->getQueryParams()['deliverer_person'];
        } else {
            $deliverer_person = null;
        }
        if (isset($request->getQueryParams()['receiver_person'])) {
            $receiver_person = (int)$request->getQueryParams()['receiver_person'];
        } else {
            $receiver_person = null;
        }
        if (isset($request->getQueryParams()['pickup_person_id'])) {
            $pickup_person_id = (int)$request->getQueryParams()['pickup_person_id'];
        } else {
            $pickup_person_id = null;
        }
        if (isset($request->getQueryParams()['pickup_responsible_person_id'])) {
            $pickup_responsible_person_id = (int)$request->getQueryParams()['pickup_responsible_person_id'];
        } else {
            $pickup_responsible_person_id = null;
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
        if (isset($request->getQueryParams()['show_history'])) {
            $show_history = $request->getQueryParams()['show_history'] === 'true';
        } else {
            $show_history = false;
        }
        if (isset($request->getQueryParams()['show_future'])) {
            $show_future = $request->getQueryParams()['show_future'] === 'true';
        } else {
            $show_future = false;
        }
        if (isset($request->getQueryParams()['from_datetimez'])) {
            $from_date = $request->getQueryParams()['from_datetimez'];
        } else {
            $from_date = null;
        }
        if (isset($request->getQueryParams()['until_datetimez'])) {
            $until_date = $request->getQueryParams()['until_datetimez'];
        } else {
            $until_date = null;
        }
        if (isset($request->getQueryParams()['lookup_date'])) {
            $lookup_date = $request->getQueryParams()['lookup_date'];
        } else {
            $lookup_date = null;
        }
        if (isset($request->getQueryParams()['show_only_newest'])) {
            $show_only_newest = $request->getQueryParams()['show_only_newest'] === 'true';
        } else {
            $show_only_newest = false;
        }

        $data = $this->getPlacesAssets()->lists(
            $offset,
            $per_page,
            $search_term,
            $asset,
            $place,
            $deliverer_person,
            $receiver_person,
            $pickup_person_id,
            $pickup_responsible_person_id,
            $order_by,
            $sort_direction,
            $show_history,
            $show_future,
            $from_date,
            $until_date,
            $show_only_newest,
            $lookup_date
        );
        $total = $this->getPlacesAssets()->count(
            $search_term,
            $asset,
            $place,
            $deliverer_person,
            $receiver_person,
            $pickup_person_id,
            $pickup_responsible_person_id,
            $show_history,
            $show_future,
            $from_date,
            $until_date,
            $show_only_newest,
            $lookup_date
        );
        $data['total'] = $total;

        return new JsonResponse($data);
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
     * @return PlacesAssetsOverviewHandler
     */
    public function setPlacesAssets(PlacesAssets $places_assets): PlacesAssetsOverviewHandler
    {
        $this->places_assets = $places_assets;
        return $this;
    }
}

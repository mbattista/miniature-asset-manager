<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\Asset;
use AssetManager\Models\Citrix;
use AssetManager\Models\Enduser;
use AssetManager\Models\Place;
use AssetManager\Models\PlacesAssets;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SearchOverviewHandler implements RequestHandlerInterface
{
    protected Place $place;
    protected Asset $asset;
    protected Enduser $enduser;
    protected Citrix $citrix;
    protected PlacesAssets $placesAssets;
    protected User $user;

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
        $data = $this->getPlace()->lists($offset, $per_page, $search_term);
        array_walk($data, function (&$item) {
            $item['isType'] = 'place';
        });
        $total = $this->getPlace()->count($search_term);

        $tmp = $this->getAsset()->listAssets($offset, $per_page, $search_term, null, null, true);
        array_walk($tmp, function (&$item) {
            $item['isType'] = 'asset';
        });
        $data = array_merge($data, $tmp);
        $total =  $total + $this->getAsset()->count($search_term, true);

        $tmp = $this->getEnduser()->lists($offset, $per_page, $search_term);
        array_walk($tmp, function (&$item) {
            $item['isType'] = 'end_user';
        });
        $data = array_merge($data, $tmp);
        $total =  $total + $this->getEnduser()->count($search_term);

        $tmp = $this->getCitrix()->lists($offset, $per_page, $search_term);
        array_walk($tmp, function (&$item) {
            $item['isType'] = 'citrix';
        });
        $data = array_merge($data, $tmp);
        $total =  $total + $this->getCitrix()->count($search_term);


        $tmp = $this->getUser()->lists($offset, $per_page, $search_term);
        array_walk($tmp, function (&$item) {
            $item['isType'] = 'user';
        });
        $data = array_merge($data, $tmp);
        $total =  $total + $this->getUser()->count($search_term);

        $tmp = $this->getPlacesAssets()->listPlacesAssetsExternalPerson($offset, $per_page, $search_term);
        array_walk($tmp, function (&$item) {
            $item['isType'] = 'external_user';
        });
        $data = array_merge($data, $tmp);
        $total =  $total + $this->getPlacesAssets()->countPlacesAssetsExternalPerson($search_term);

        /*$tmp = $this->getPlacesAssets()->lists($offset, $per_page, $search_term);
        array_walk($tmp, function (&$item) {
            $item['isType'] = 'places_assets';
        });
        $data = array_merge($data, $tmp);
        $total =  $total + $this->getPlacesAssets()->count($search_term);*/

        usort($data, function ($a, $b)
        {
            if (isset($a['weight']) && isset($b['weight'])) {
                return $b['weight'] <=> $a['weight'];
            } else {
                return $a['id'] <=> $b['id'];
            }
        });
        $data['total'] = $total;

        return new JsonResponse($data);
    }

    /**
     * @return Place
     */
    public function getPlace(): Place
    {
        return $this->place;
    }

    /**
     * @param Place $place
     * @return SearchOverviewHandler
     */
    public function setPlace(Place $place): SearchOverviewHandler
    {
        $this->place = $place;
        return $this;
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
     * @return SearchOverviewHandler
     */
    public function setAsset(Asset $asset): SearchOverviewHandler
    {
        $this->asset = $asset;
        return $this;
    }

    /**
     * @return Enduser
     */
    public function getEnduser(): Enduser
    {
        return $this->enduser;
    }

    /**
     * @param Enduser $enduser
     * @return SearchOverviewHandler
     */
    public function setEnduser(Enduser $enduser): SearchOverviewHandler
    {
        $this->enduser = $enduser;
        return $this;
    }

    /**
     * @return PlacesAssets
     */
    public function getPlacesAssets(): PlacesAssets
    {
        return $this->placesAssets;
    }

    /**
     * @param PlacesAssets $placesAssets
     * @return SearchOverviewHandler
     */
    public function setPlacesAssets(PlacesAssets $placesAssets): SearchOverviewHandler
    {
        $this->placesAssets = $placesAssets;
        return $this;
    }

    /**
     * @return Citrix
     */
    public function getCitrix(): Citrix
    {
        return $this->citrix;
    }

    /**
     * @param Citrix $citrix
     * @return SearchOverviewHandler
     */
    public function setCitrix(Citrix $citrix): SearchOverviewHandler
    {
        $this->citrix = $citrix;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return SearchOverviewHandler
     */
    public function setUser(User $user): SearchOverviewHandler
    {
        $this->user = $user;
        return $this;
    }
}

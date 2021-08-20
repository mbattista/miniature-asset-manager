<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Models\Enduser;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserOverviewHandler implements RequestHandlerInterface
{
    protected Enduser $end_user;

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

        $person = null;
        if (isset($request->getQueryParams()['person']) && is_numeric($request->getQueryParams()['person'])) {
            $person = (int)$request->getQueryParams()['person'];
        }

        $place = null;
        if (isset($request->getQueryParams()['place']) && is_numeric($request->getQueryParams()['place'])) {
            $place = (int)$request->getQueryParams()['place'];
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
        $data = $this->getEndUser()->lists($offset, $per_page, $search_term, $person, $place, $order_by, $sort_direction, $show_inactive);
        $total = $this->getEndUser()->count($search_term, $person, $place, $show_inactive);
        $data['total'] = $total;

        return new JsonResponse($data);
    }

    /**
     * @return Enduser
     */
    public function getEndUser(): Enduser
    {
        return $this->end_user;
    }

    /**
     * @param Enduser $end_user
     * @return EndUserOverviewHandler
     */
    public function setEndUser(Enduser $end_user): EndUserOverviewHandler
    {
        $this->end_user = $end_user;
        return $this;
    }
}

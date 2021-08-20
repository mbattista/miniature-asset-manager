<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Models\Citrix;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixOverviewHandler implements RequestHandlerInterface
{
    protected Citrix $citrix;

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
        if (isset($request->getQueryParams()['show_only_available'])) {
            $show_only_available = false;
            if ($request->getQueryParams()['show_only_available'] === 'true') {
                $show_only_available = true;
            }
        } else {
            $show_only_available = null;
        }
        $data = $this->getCitrix()->lists($offset, $per_page, $search_term, $order_by, $sort_direction, $show_only_available);
        $total = $this->getCitrix()->count($search_term);
        $data['total'] = $total;

        return new JsonResponse($data);
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
     * @return CitrixOverviewHandler
     */
    public function setCitrix(Citrix $citrix): CitrixOverviewHandler
    {
        $this->citrix = $citrix;
        return $this;
    }
}

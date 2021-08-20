<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\PlaceNotFoundException;
use AssetManager\Models\Place;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlaceDeleteHandler implements RequestHandlerInterface
{
    protected Place $place;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     * @throws PlaceNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('place');
        $this->getPlace()->get($id);
        $this->getPlace()->delete();

        return new JsonResponse(['deleting' => 'success']);
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
     * @return PlaceDeleteHandler
     */
    public function setPlace(Place $place): PlaceDeleteHandler
    {
        $this->place = $place;
        return $this;
    }
}

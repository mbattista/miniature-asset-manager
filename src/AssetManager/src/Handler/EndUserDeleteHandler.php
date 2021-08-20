<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\UserNotFoundException;
use AssetManager\Models\Enduser;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserDeleteHandler implements RequestHandlerInterface
{
    protected Enduser $end_user;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     * @throws UserNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('end_user');
        $this->getEndUser()->get($id);
        $this->getEndUser()->delete();

        return new JsonResponse(['deleting' => 'success']);
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
     * @return EndUserDeleteHandler
     */
    public function setEndUser(Enduser $end_user): EndUserDeleteHandler
    {
        $this->end_user = $end_user;
        return $this;
    }
}

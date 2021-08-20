<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\UserNotFoundException;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUserDetailHandler implements RequestHandlerInterface
{
    protected User $user;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     * @throws UserNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('user');
        $this->getUser()->get($id);

        return new JsonResponse($this->getUser()->toArray());
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
     * @return AssetUserDetailHandler
     */
    public function setUser(User $user): AssetUserDetailHandler
    {
        $this->user = $user;
        return $this;
    }
}

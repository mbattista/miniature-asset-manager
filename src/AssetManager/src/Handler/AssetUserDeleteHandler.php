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

class AssetUserDeleteHandler implements RequestHandlerInterface
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
        $this->getUser()->delete();

        return new JsonResponse(['deleting' => 'success']);
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
     * @return AssetUserDeleteHandler
     */
    public function setUser(User $user): AssetUserDeleteHandler
    {
        $this->user = $user;
        return $this;
    }
}

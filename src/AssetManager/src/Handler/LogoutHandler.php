<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\InvalidException;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutHandler implements RequestHandlerInterface
{
    protected User $user;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $this->getUser()->get($request->getAttribute('user_id'));

        $this->getUser()->deleteToken();

        return new JsonResponse(
            [
                'logout' => true,
            ]
        );
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
     * @return LogoutHandler
     */
    public function setUser(User $user): LogoutHandler
    {
        $this->user = $user;
        return $this;
    }
}

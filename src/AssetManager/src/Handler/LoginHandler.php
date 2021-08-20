<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\InvalidException;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginHandler implements RequestHandlerInterface
{
    protected User $user;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;

        $json_body = json_decode($request->getBody()->getContents(), true);

        if (isset($json_body['email'])) {
            $user_email = $json_body['email'];
        } else {
            $errored = true;
        }

        if (isset($json_body['password'])) {
            $user_password = $json_body['password'];
        } else {
            $errored = true;
        }


        if ($errored) {
            throw new InvalidException('Missing login data');
        }
        $user_id = $this->user->authorize($user_email, $user_password);
        $this->user->get($user_id);
        if (
            $this->user->getApiToken() === null ||
            ($this->user->getApiToken() !== null && $this->user->authorizeToken($this->user->getApiToken()) === 0)
        ) {
            $token = $this->user->createToken();
        } else {
            $token = $this->user->getApiToken();
        }
        $admin = $this->user->checkAdmin();

        return new JsonResponse(
            [
                'id' => $this->user->getId(),
                'first_name' => $this->user->getFirstName(),
                'last_name' => $this->user->getLastName(),
                'token' => $token,
                'admin' => $admin,
                'per_page_preference' => $this->user->getPerPagePreference(),
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
     * @return LoginHandler
     */
    public function setUser(User $user): LoginHandler
    {
        $this->user = $user;
        return $this;
    }
}

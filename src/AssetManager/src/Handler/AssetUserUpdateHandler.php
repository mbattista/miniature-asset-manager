<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\UserNotFoundException;
use AssetManager\Models\Person;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUserUpdateHandler implements RequestHandlerInterface
{
    protected User $user;
    protected Person $person;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     * @throws UserNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $json_body = json_decode($request->getBody()->getContents(), true);
        $errored = false;
        $error_message = [];

        $id = (int)$request->getAttribute('user');
        $this->getUser()->get($id);
        if (isset($json_body['person']) && empty($json_body['person'])) {
            unset($json_body['person']);
        }
        if (isset($json_body['person']) && is_int($json_body['person'])) {
            $this->getPerson()->get($json_body['person']);
            $this->getUser()->setPerson($json_body['person']);
        } elseif (isset($json_body['person'])) {
            $errored = true;
            $error_message = ['person' => 'needs to be integer'];
        } else {
            $errored = true;
            $error_message = ['person' => 'required'];
        }

        if (isset($json_body['email']) && empty($json_body['email'])) {
            unset($json_body['email']);
        }
        if (isset($json_body['email']) && is_string($json_body['email'])) {
            $this->getUser()->setEmail($json_body['email']);
        } elseif (isset($json_body['email'])) {
            $errored = true;
            $error_message = ['email' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['email' => 'required'];
        }

        if (isset($json_body['nickname']) && empty($json_body['nickname'])) {
            unset($json_body['nickname']);
        }
        if (isset($json_body['nickname']) && is_string($json_body['nickname'])) {
            $this->getUser()->setNickname($json_body['nickname']);
        } elseif (isset($json_body['nickname'])) {
            $errored = true;
            $error_message = ['nickname' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['nickname' => 'required'];
        }

        if (isset($json_body['password']) && empty($json_body['password'])) {
            unset($json_body['password']);
        }
        if (isset($json_body['password']) && is_string($json_body['password'])) {
            $this->getUser()->setPassword($json_body['password']);
        } elseif (isset($json_body['password'])) {
            $errored = true;
            $error_message = ['password' => 'needs to be string'];
        }

        if (isset($json_body['deactivated']) && empty($json_body['deactivated'])) {
            unset($json_body['deactivated']);
        }
        if (isset($json_body['deactivated']) && is_bool($json_body['deactivated'])) {
            $this->getUser()->setDeactivated($json_body['deactivated']);
        } elseif (isset($json_body['deactivated'])) {
            $errored = true;
            $error_message = ['deactivated' => 'needs to be boolean'];
        } else {
            $this->getUser()->setDeactivated(false);
        }

        if (!$errored) {
            $this->getUser()->update();
            return new JsonResponse(['updated' => true]);
        } else {
            return new JsonResponse(['updated' => false, 'error' => $error_message], 400);
        }
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
     * @return AssetUserUpdateHandler
     */
    public function setUser(User $user): AssetUserUpdateHandler
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     * @return AssetUserUpdateHandler
     */
    public function setPerson(Person $person): AssetUserUpdateHandler
    {
        $this->person = $person;
        return $this;
    }
}

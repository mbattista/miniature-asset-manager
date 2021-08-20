<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\Person;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUserCreateHandler implements RequestHandlerInterface
{
    protected User $user;
    protected User $issuer;
    protected Person $person;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $this->issuer->get($request->getAttribute('user_id'));
        if (!$this->issuer->checkAdmin()) {
            return new JsonResponse([ 'NotAllowed' => 'This Operation is only allowed for admin users' ]);
        }
        $errored = false;
        $error_message = [];

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['person']) && empty($json_body['person'])) {
            unset($json_body['person']);
        }
        if (isset($json_body['person']) && is_int($json_body['person'])) {
            $this->getPerson()->get($json_body['person']);
            $this->getUser()->setPerson($json_body['person']);
        } elseif (isset($json_body['person'])) {
            $errored = true;
            $error_message = ['person' => 'needs to be integer'];
        }

        if (isset($json_body['email']) && empty($json_body['email'])) {
            unset($json_body['email']);
        }
        if (isset($json_body['email']) && is_string($json_body['email'])) {
            $this->getUser()->setEmail($json_body['email']);
        } elseif (isset($json_body['email'])) {
            $errored = true;
            $error_message = ['email' => 'needs to be string'];
        }

        if (isset($json_body['nickname']) && empty($json_body['nickname'])) {
            unset($json_body['nickname']);
        }
        if (isset($json_body['nickname']) && is_string($json_body['nickname'])) {
            $this->getUser()->setNickname($json_body['nickname']);
        } elseif (isset($json_body['nickname'])) {
            $errored = true;
            $error_message = ['nickname' => 'needs to be string'];
        }

        if (isset($json_body['deactivated']) && empty($json_body['nickname'])) {
            unset($json_body['deactivated']);
        }
        if (isset($json_body['deactivated']) && is_bool($json_body['deactivated'])) {
            $this->getUser()->setDeactivated($json_body['deactivated']);
        } elseif (isset($json_body['deactivated'])) {
            $errored = true;
            $error_message = ['deactivated' => 'needs to be boolean'];
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

        if (!$errored) {
            $id = $this->user->create();
            return new JsonResponse(['created' => true, 'id' => $id], 201);
        } else {
            return new JsonResponse(['created' => false, 'error' => $error_message], 400);
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
     * @return AssetUserCreateHandler
     */
    public function setUser(User $user): AssetUserCreateHandler
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
     * @return AssetUserCreateHandler
     */
    public function setPerson(Person $person): AssetUserCreateHandler
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return User
     */
    public function getIssuer(): User
    {
        return $this->issuer;
    }

    /**
     * @param User $issuer
     * @return AssetUserCreateHandler
     */
    public function setIssuer(User $issuer): AssetUserCreateHandler
    {
        $this->issuer = $issuer;
        return $this;
    }
}

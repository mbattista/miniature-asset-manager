<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\Person;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonCreateHandler implements RequestHandlerInterface
{
    protected Person $person;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;
        $error_message = [];

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['first_name']) && is_string($json_body['first_name'])) {
            $this->getPerson()->setFirstName($json_body['first_name']);
        } elseif (isset($json_body['first_name'])) {
            $errored = true;
            $error_message = ['first_name' => 'needs to be string'];
        }

        if (isset($json_body['last_name']) && is_string($json_body['last_name'])) {
            $this->getPerson()->setLastName($json_body['last_name']);
        } elseif (isset($json_body['last_name'])) {
            $errored = true;
            $error_message = ['last_name' => 'needs to be string'];
        }

        if (!$errored) {
            $id = $this->getPerson()->create();
            return new JsonResponse(['created' => true, 'id' => $id], 201);
        } else {
            return new JsonResponse(['created' => false, 'error' => $error_message], 400);
        }
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
     * @return PersonCreateHandler
     */
    public function setPerson(Person $person): PersonCreateHandler
    {
        $this->person = $person;
        return $this;
    }
}


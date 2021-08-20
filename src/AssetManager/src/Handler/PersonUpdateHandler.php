<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\PersonNotFoundException;
use AssetManager\Models\Person;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonUpdateHandler implements RequestHandlerInterface
{
    protected Person $person;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     * @throws PersonNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;
        $error_message = [];

        $id = (int)$request->getAttribute('person');
        $this->getPerson()->get($id);

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['first_name']) && is_string($json_body['first_name'])) {
            $this->getPerson()->setFirstName($json_body['first_name']);
        } elseif (isset($json_body['first_name'])) {
            $errored = true;
            $error_message = ['first_name' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['first_name' => 'required'];
        }

        if (isset($json_body['last_name']) && is_string($json_body['last_name'])) {
            $this->getPerson()->setLastName($json_body['last_name']);
        } elseif (isset($json_body['last_name'])) {
            $errored = true;
            $error_message = ['last_name' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['last_name' => 'required'];
        }

        if (!$errored) {
            $this->getPerson()->update();
            return new JsonResponse(['updated' => true]);
        } else {
            return new JsonResponse(['updated' => false, 'error' => $error_message], 400);
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
     * @return PersonUpdateHandler
     */
    public function setPerson(Person $person): PersonUpdateHandler
    {
        $this->person = $person;
        return $this;
    }
}

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

class PersonDetailHandler implements RequestHandlerInterface
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
        $id = (int)$request->getAttribute('person');
        $this->getPerson()->get($id);

        return new JsonResponse($this->getPerson()->toArray());
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
     * @return PersonDetailHandler
     */
    public function setPerson(Person $person): PersonDetailHandler
    {
        $this->person = $person;
        return $this;
    }
}

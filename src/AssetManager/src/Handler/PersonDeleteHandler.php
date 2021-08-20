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

class PersonDeleteHandler implements RequestHandlerInterface
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
        $this->getPerson()->delete();

        return new JsonResponse(['deleting' => 'success']);
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
     * @return PersonDeleteHandler
     */
    public function setPerson(Person $person): PersonDeleteHandler
    {
        $this->person = $person;
        return $this;
    }
}

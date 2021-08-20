<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\CitrixNotFoundException;
use AssetManager\Error\DatabaseError;
use AssetManager\Models\Citrix;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixDeleteHandler implements RequestHandlerInterface
{
    protected Citrix $citrix;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError
     * @throws CitrixNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('citrix');
        $this->getCitrix()->get($id);
        $this->getCitrix()->delete();

        return new JsonResponse(['deleting' => 'success']);
    }

    /**
     * @return Citrix
     */
    public function getCitrix(): Citrix
    {
        return $this->citrix;
    }

    /**
     * @param Citrix $citrix
     * @return CitrixDeleteHandler
     */
    public function setCitrix(Citrix $citrix): CitrixDeleteHandler
    {
        $this->citrix = $citrix;
        return $this;
    }
}

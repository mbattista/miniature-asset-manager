<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\CitrixNotFoundException;
use AssetManager\Models\Citrix;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixDetailHandler implements RequestHandlerInterface
{
    protected Citrix $citrix;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws CitrixNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('citrix');
        $this->getCitrix()->get($id);

        return new JsonResponse($this->getCitrix()->toArray());
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
     * @return CitrixDetailHandler
     */
    public function setCitrix(Citrix $citrix): CitrixDetailHandler
    {
        $this->citrix = $citrix;
        return $this;
    }
}

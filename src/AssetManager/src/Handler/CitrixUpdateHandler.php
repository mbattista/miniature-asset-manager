<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\PersonNotFoundException;
use AssetManager\Models\Citrix;
use AssetManager\Models\Person;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CitrixUpdateHandler implements RequestHandlerInterface
{
    protected Citrix $citrix;

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

        $id = (int)$request->getAttribute('citrix');
        $this->getCitrix()->get($id);

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['citrix_number']) && is_string($json_body['citrix_number'])) {
            $this->getCitrix()->setNumber($json_body['citrix_number']);
        } elseif (isset($json_body['citrix_number'])) {
            $errored = true;
            $error_message = ['citrix_number' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['citrix_number' => 'required'];
        }

        if (isset($json_body['password']) && is_string($json_body['password'])) {
            $this->getCitrix()->setPassword($json_body['password']);
        } elseif (isset($json_body['password'])) {
            $errored = true;
            $error_message = ['password' => 'needs to be string'];
        }

        if (isset($json_body['show_id']) && is_string($json_body['show_id'])) {
            $this->getCitrix()->setShowId($json_body['show_id']);
        } elseif (isset($json_body['show_id'])) {
            $errored = true;
            $error_message = ['show_id' => 'needs to be string'];
        }

        if (!$errored) {
            $this->getCitrix()->update();
            return new JsonResponse(['updated' => true]);
        } else {
            return new JsonResponse(['updated' => false, 'error' => $error_message], 400);
        }
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
     * @return CitrixUpdateHandler
     */
    public function setCitrix(Citrix $citrix): CitrixUpdateHandler
    {
        $this->citrix = $citrix;
        return $this;
    }
}

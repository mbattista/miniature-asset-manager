<?php

declare(strict_types=1);

namespace AssetManager\Middleware;

use AssetManager\Error\InvalidException;
use AssetManager\Error\NotFoundException;
use AssetManager\Error\UniqueError;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RestErrorCatcherMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (NotFoundException $e) {
            return new JsonResponse(['error' => 'NotFound'], StatusCodeInterface::STATUS_NOT_FOUND);
        } catch (InvalidException $e) {
            return new JsonResponse(['error' => 'InvalidInput', 'message' => $e->getMessage()], StatusCodeInterface::STATUS_BAD_REQUEST);
        } catch (UniqueError $e) {
            return new JsonResponse(['error' => 'DuplicateInput', 'message' => $e->getMessage()], StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        return $response;
    }
}

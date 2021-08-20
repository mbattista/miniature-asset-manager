<?php

declare(strict_types=1);

namespace AssetManager\Middleware;

use AssetManager\Models\User;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        if (! $routeResult || ! $routeResult->isMethodFailure()) {
            return $handler->handle($request)
                ->withAddedHeader('Access-Control-Allow-Origin', '*')
                ->withAddedHeader('Access-Control-Allow-Headers', 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, authorization, Authorization');
        } else {
            return $handler->handle($request)
                ->withAddedHeader('Access-Control-Allow-Origin', '*')
                ->withAddedHeader('Access-Control-Allow-Methods', implode(',', $routeResult->getAllowedMethods()))
                ->withAddedHeader('Access-Control-Allow-Headers', 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, authorization, Authorization');
        }
    }
}

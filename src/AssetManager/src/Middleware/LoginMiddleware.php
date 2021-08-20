<?php

declare(strict_types=1);

namespace AssetManager\Middleware;

use AssetManager\Models\User;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginMiddleware implements MiddlewareInterface
{
    protected User $user;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $auth_header = null;
        if ($request->hasHeader('authorization')) {
            $auth_header = $request->getHeader('authorization')[0];
        } elseif ($request->hasHeader('Authorization')) {
            $auth_header = $request->getHeader('Authorization')[0];
        }
        if ($auth_header !== null) {
            $auth= $request->getHeader('Authorization')[0];
            if (strpos($auth, 'Basic') !== false) {
                $tmp = explode('Basic ', $auth);
                $user_data = explode(':', base64_decode($tmp[1]));
                if (count($user_data) === 2) {
                    $user_id = $this->user->authorize($user_data[0], $user_data[1]);
                    if ($user_id > 0) {
                        return $handler->handle($request->withAttribute('user_id', $user_id));
                    } else {
                        return new JsonResponse('Authentification needed', StatusCodeInterface::STATUS_UNAUTHORIZED);
                    }
                }
            } elseif (strpos($auth, 'Bearer') !== false) {
                $tmp = explode('Bearer ', $auth);
                if (count($tmp) === 2) {
                    $user_id = $this->user->authorizeToken($tmp[1]);
                    if ($user_id > 0) {
                        $this->user->get($user_id)->updateToken();
                        return $handler->handle($request->withAttribute('user_id', $user_id));
                    } else {
                        return new JsonResponse('Authentification needed', StatusCodeInterface::STATUS_UNAUTHORIZED);
                    }
                }
            }
        }
        /** @var RouteResult $route */
        $route = $request->getAttribute(RouteResult::class);
        if (is_object($route->getMatchedRoute()) && $route->getMatchedRoute()->getName() === 'login-create') {
            return $handler->handle($request);
        }

        return new JsonResponse(['Error' => 'LoginRequired'], StatusCodeInterface::STATUS_BAD_REQUEST);
    }

    /**
     * @param User $user
     * @return LoginMiddleware
     */
    public function setUser(User $user): LoginMiddleware
    {
        $this->user = $user;
        return $this;
    }
}

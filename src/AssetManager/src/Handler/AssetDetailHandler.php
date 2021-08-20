<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\AssetNotFoundException;
use AssetManager\Error\DatabaseError;
use AssetManager\Models\Asset;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetDetailHandler implements RequestHandlerInterface
{
    protected Asset $asset;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws AssetNotFoundException
     * @throws DatabaseError
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = (int)$request->getAttribute('asset');
        $this->getAsset()->get($id);

        return new JsonResponse($this->getAsset()->toArray());
    }

    /**
     * @return Asset
     */
    public function getAsset(): Asset
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     * @return $this
     */
    public function setAsset(Asset $asset): AssetDetailHandler
    {
        $this->asset = $asset;
        return $this;
    }
}

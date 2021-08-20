<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Models\Asset;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DashboardHandler implements RequestHandlerInterface
{
    /**
     * @var Asset $asset
     */
    public $asset;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];

        //$this->asset->setId(2);
        $this->asset->setName("Test3");
        $this->asset->setType("Test2");
        $this->asset->setText("Test1");

        $test = $this->asset->listAssets(0, 25, "tes");

        return new JsonResponse(['ok' => $test]);
    }
}

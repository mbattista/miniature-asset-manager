<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\CitrixNotFoundException;
use AssetManager\Models\Asset;
use AssetManager\Models\Citrix;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AssetUpdateHandler implements RequestHandlerInterface
{
    protected Asset $asset;
    protected Citrix $citrix;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $json_body = json_decode($request->getBody()->getContents(), true);
        $errored = false;
        $error_message = [];

        $id = (int)$request->getAttribute('asset');
        $this->getAsset()->get($id);

        if (isset($json_body['serial']) && empty($json_body['serial'])) {
            unset($json_body['serial']);
        }
        if (isset($json_body['serial']) && is_string($json_body['serial'])) {
            $this->getAsset()->setSerial($json_body['serial']);
        } elseif (isset($json_body['serial'])) {
            $errored = true;
            $error_message = ['serial' => 'needs to be string'];
        } else {
            $this->getAsset()->setSerial(null);
        }

        if (isset($json_body['active']) && empty($json_body['active'])) {
            unset($json_body['active']);
        }
        if (isset($json_body['active']) && is_bool($json_body['active'])) {
            $this->getAsset()->setActive($json_body['active']);
        } elseif (isset($json_body['active'])) {
            $errored = true;
            $error_message = ['active' => 'needs to be boolean'];
        } else {
            $this->getAsset()->setActive(false);
        }

        if (isset($json_body['name']) && empty($json_body['name'])) {
            unset($json_body['name']);
        }
        if (isset($json_body['name']) && is_string($json_body['name'])) {
            $this->getAsset()->setName($json_body['name']);
        } elseif (isset($json_body['name'])) {
            $errored = true;
            $error_message = ['name' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['name' => 'required'];
        }

        if (isset($json_body['type']) && empty($json_body['type'])) {
            unset($json_body['type']);
        }
        if (isset($json_body['type']) && is_string($json_body['type'])) {
            $this->getAsset()->setType($json_body['type']);
        } elseif (isset($json_body['type'])) {
            $errored = true;
            $error_message = ['type' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['type' => 'required'];
        }

        if (isset($json_body['out_of_order']) && empty($json_body['out_of_order'])) {
            unset($json_body['out_of_order']);
        }
        if (isset($json_body['out_of_order']) && is_bool($json_body['out_of_order'])) {
            $this->getAsset()->setOutOfOrder($json_body['out_of_order']);
        } elseif (isset($json_body['out_of_order'])) {
            $errored = true;
            $error_message = ['out_of_order' => 'needs to be boolean'];
        } else {
            $this->getAsset()->setOutOfOrder(false);
        }

        if (isset($json_body['is_loan']) && empty($json_body['is_loan'])) {
            unset($json_body['is_loan']);
        }
        if (isset($json_body['is_loan']) && is_bool($json_body['is_loan'])) {
            $this->getAsset()->setIsLoan($json_body['is_loan']);
        } elseif (isset($json_body['is_loan'])) {
            $errored = true;
            $error_message = ['is_loan' => 'needs to be boolean'];
        } else {
            $this->getAsset()->setIsLoan(true);
        }

        if (isset($json_body['teamviewer_id']) && empty($json_body['teamviewer_id'])) {
            unset($json_body['teamviewer_id']);
        }
        if (isset($json_body['teamviewer_id']) && is_string($json_body['teamviewer_id'])) {
            $this->getAsset()->setTeamviewerId($json_body['teamviewer_id']);
        } elseif (isset($json_body['teamviewer_id'])) {
            $errored = true;
            $error_message = ['teamviewer_id' => 'needs to be string'];
        }

        if (isset($json_body['citrix']) && empty($json_body['citrix'])) {
            unset($json_body['citrix']);
            $this->getAsset()->setCitrix(null);
        }
        if (isset($json_body['citrix']) && is_array($json_body['citrix'])) {
            try {
                foreach ($json_body['citrix'] as $item) {
                    $this->getCitrix()->get((int)$item);
                }
                $this->getAsset()->setCitrix($json_body['citrix']);
            } catch (CitrixNotFoundException $e) {
                $errored = true;
                $error_message = ['citrix' => 'not exists'];
            }
        } elseif (isset($json_body['citrix'])) {
            $errored = true;
            $error_message = ['citrix' => 'needs to be an array'];
        }

        if (isset($json_body['text']) && empty($json_body['text'])) {
            unset($json_body['text']);
        }
        if (isset($json_body['text']) && is_string($json_body['text'])) {
            $this->getAsset()->setText($json_body['text']);
        } elseif (isset($json_body['text'])) {
            $errored = true;
            $error_message = ['text' => 'needs to be string'];
        } else {
            $this->getAsset()->setText(null);
        }

        if (!$errored) {
            $this->getAsset()->update();
            return new JsonResponse(['updated' => true]);
        } else {
            return new JsonResponse(['updated' => false, 'error' => $error_message], 400);
        }
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
    public function setAsset(Asset $asset): self
    {
        $this->asset = $asset;
        return $this;
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
     * @return AssetUpdateHandler
     */
    public function setCitrix(Citrix $citrix): AssetUpdateHandler
    {
        $this->citrix = $citrix;
        return $this;
    }
}

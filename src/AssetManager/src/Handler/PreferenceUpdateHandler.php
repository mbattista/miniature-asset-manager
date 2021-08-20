<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\UserNotFoundException;
use AssetManager\Models\User;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PreferenceUpdateHandler implements RequestHandlerInterface
{
    protected User $asset_user;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DatabaseError|UserNotFoundException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;
        $error_message = [];

        $id = (int)$request->getAttribute('user');
        $this->getAssetUser()->get($id);

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['per_page_preference']) && empty($json_body['per_page_preference'])) {
            unset($json_body['per_page_preference']);
        }
        if (isset($json_body['per_page_preference']) && is_numeric($json_body['per_page_preference'])) {
            $this->getAssetUser()->setPerPagePreference($json_body['per_page_preference']);
        } elseif (isset($json_body['per_page_preference'])) {
            $errored = true;
            $error_message = ['per_page_preference' => 'needs to be numberic'];
        } else {
            $errored = true;
            $error_message = ['per_page_preference' => 'per_page_preference'];
        }

        if (!$errored) {
            $this->getAssetUser()->updatePreferences();
            return new JsonResponse(['updated' => true]);
        } else {
            return new JsonResponse(['updated' => false, 'error' => $error_message], 400);
        }
    }

    /**
     * @return User
     */
    public function getAssetUser(): User
    {
        return $this->asset_user;
    }

    /**
     * @param User $asset_user
     * @return PreferenceUpdateHandler
     */
    public function setAssetUser(User $asset_user): PreferenceUpdateHandler
    {
        $this->asset_user = $asset_user;
        return $this;
    }
}

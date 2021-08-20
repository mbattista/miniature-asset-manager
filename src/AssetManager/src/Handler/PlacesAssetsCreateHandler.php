<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\AssetNotFoundException;
use AssetManager\Error\PersonNotFoundException;
use AssetManager\Error\PlaceNotFoundException;
use AssetManager\Models\Asset;
use AssetManager\Models\Place;
use AssetManager\Models\PlacesAssets;
use AssetManager\Models\User;
use DateTime;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlacesAssetsCreateHandler implements RequestHandlerInterface
{
    protected PlacesAssets $places_assets;
    protected Asset $asset;
    protected Place $place;
    protected User $person;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;
        $error_message = [];

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['place']) && empty($json_body['place'])) {
            unset($json_body['place']);
        }
        if (isset($json_body['place']) && is_int($json_body['place'])) {
            try {
                $this->getPlace()->get($json_body['place']);
                $this->getPlacesAssets()->setPlace($json_body['place']);
            } catch (PlaceNotFoundException $e) {
                $errored = true;
                $error_message = ['place' => 'not exists'];
            }
        } elseif (isset($json_body['place'])) {
            $errored = true;
            $error_message = ['place' => 'needs to be integer'];
        } else {
            $errored = true;
            $error_message = ['place' => 'required'];
        }

        if (isset($json_body['asset']) && empty($json_body['asset'])) {
            unset($json_body['asset']);
        }
        if (isset($json_body['asset']) && is_int($json_body['asset'])) {
            try {
                $this->getAsset()->get($json_body['asset']);
                $this->getPlacesAssets()->setAsset($json_body['asset']);
            } catch (AssetNotFoundException $e) {
                $errored = true;
                $error_message = ['asset' => 'not exists'];
            }
        } elseif (isset($json_body['asset'])) {
            $errored = true;
            $error_message = ['asset' => 'needs to be integer'];
        } else {
            $errored = true;
            $error_message = ['asset' => 'required'];
        }

        if (isset($json_body['deliverer_person']) && empty($json_body['deliverer_person'])) {
            unset($json_body['deliverer_person']);
        }
        if (isset($json_body['deliverer_person']) && is_int($json_body['deliverer_person'])) {
            try {
                $this->getPerson()->get($json_body['deliverer_person']);
                $this->getPlacesAssets()->setDelivererPerson($json_body['deliverer_person']);
            } catch (PersonNotFoundException $e) {
                $errored = true;
                $error_message = ['deliverer_person' => 'not exists'];
            }
        } elseif (isset($json_body['deliverer_person'])) {
            $errored = true;
            $error_message = ['deliverer_person' => 'needs to be integer'];
        }

        if (isset($json_body['receiver_person']) && empty($json_body['receiver_person'])) {
            unset($json_body['receiver_person']);
        }
        if (isset($json_body['receiver_person']) && is_int($json_body['receiver_person'])) {
            try {
                $this->getPerson()->get($json_body['receiver_person']);
                $this->getPlacesAssets()->setReceiverPerson($json_body['receiver_person']);
            } catch (PersonNotFoundException $e) {
                $errored = true;
                $error_message = ['receiver_person' => 'not exists'];
            }
        } elseif (isset($json_body['receiver_person'])) {
            $errored = true;
            $error_message = ['receiver_person' => 'needs to be integer'];
        }

        if (isset($json_body['pickup_person_id']) && empty($json_body['pickup_person_id'])) {
            unset($json_body['pickup_person_id']);
        }
        if (isset($json_body['pickup_person_id']) && is_int($json_body['pickup_person_id'])) {
            try {
                $this->getPerson()->get($json_body['pickup_person_id']);
                $this->getPlacesAssets()->setPickupPersonId($json_body['pickup_person_id']);
            } catch (PersonNotFoundException $e) {
                $errored = true;
                $error_message = ['pickup_person_id' => 'not exists'];
            }
        } elseif (isset($json_body['pickup_person_id'])) {
            $errored = true;
            $error_message = ['pickup_person_id' => 'needs to be integer'];
        }

        if (isset($json_body['pickup_responsible_person_id']) && empty($json_body['pickup_responsible_person_id'])) {
            unset($json_body['pickup_responsible_person_id']);
        }
        if (isset($json_body['pickup_responsible_person_id']) && is_int($json_body['pickup_responsible_person_id'])) {
            try {
                $this->getPerson()->get($json_body['pickup_responsible_person_id']);
                $this->getPlacesAssets()->setPickupResponsiblePersonId($json_body['pickup_responsible_person_id']);
            } catch (PersonNotFoundException $e) {
                $errored = true;
                $error_message = ['pickup_responsible_person_id' => 'not exists'];
            }
        } elseif (isset($json_body['pickup_responsible_person_id'])) {
            $errored = true;
            $error_message = ['pickup_responsible_person_id' => 'needs to be integer'];
        }

        if (isset($json_body['automatic_callback']) && empty($json_body['automatic_callback'])) {
            unset($json_body['automatic_callback']);
        }
        if (isset($json_body['automatic_callback']) && is_bool($json_body['automatic_callback'])) {
            $this->getPlacesAssets()->setAutomaticCallback($json_body['automatic_callback']);
        } elseif (isset($json_body['automatic_callback'])) {
            $errored = true;
            $error_message = ['automatic_callback' => 'needs to be boolean'];
        } else {
            $this->getPlacesAssets()->setAutomaticCallback(false);
        }

        if (isset($json_body['delivered']) && empty($json_body['delivered'])) {
            unset($json_body['delivered']);
        }
        if (isset($json_body['delivered']) && is_bool($json_body['delivered'])) {
            $this->getPlacesAssets()->setDelivered($json_body['delivered']);
        } elseif (isset($json_body['delivered'])) {
            $errored = true;
            $error_message = ['delivered' => 'needs to be boolean'];
        } else {
            $this->getPlacesAssets()->setDelivered(false);
        }

        if (isset($json_body['text']) && empty($json_body['text'])) {
            unset($json_body['text']);
        }
        if (isset($json_body['text']) && is_string($json_body['text'])) {
            $this->getPlacesAssets()->setText($json_body['text']);
        } elseif (isset($json_body['text'])) {
            $errored = true;
            $error_message = ['text' => 'needs to be string'];
        }

        if (isset($json_body['external_person']) && empty($json_body['external_person'])) {
            unset($json_body['external_person']);
        }
        if (isset($json_body['external_person']) && is_string($json_body['external_person'])) {
            $this->getPlacesAssets()->setExternalPerson($json_body['external_person']);
        } elseif (isset($json_body['external_person'])) {
            $errored = true;
            $error_message = ['external_person' => 'needs to be string'];
        }

        if (isset($json_body['delivery_datetimez']) && !empty($json_body['delivery_datetimez']) && is_string($json_body['delivery_datetimez'])) {
            $date = DateTime::createFromFormat('d.m.Y', $json_body['delivery_datetimez']);
            if ($date !== false) {
                $this->getPlacesAssets()->setDeliveryDatetimez($date);
            } else {
                $errored = true;
                $error_message = ['delivery_datetimez' => 'needs to be a string in format d.m.Y'];
            }
        } elseif (isset($json_body['delivery_datetimez'])) {
            $errored = true;
            $error_message = ['delivery_datetimez' => 'needs to be a string in format d.m.Y'];
        }
        if (isset($json_body['from_datetimez']) && !empty($json_body['from_datetimez']) && is_string($json_body['from_datetimez'])) {
            $date = DateTime::createFromFormat('d.m.Y', $json_body['from_datetimez']);
            if ($date !== false) {
                $this->getPlacesAssets()->setFromDatetimez($date);
            } else {
                $errored = true;
                $error_message = ['from_datetimez' => 'needs to be a string in format d.m.Y'];
            }
        } elseif (isset($json_body['from_datetimez'])) {
            $errored = true;
            $error_message = ['from_datetimez' => 'needs to be a string in format d.m.Y'];
        }
        if (isset($json_body['until_datetimez']) && !empty($json_body['until_datetimez']) && is_string($json_body['until_datetimez'])) {
            $date = DateTime::createFromFormat('d.m.Y', $json_body['until_datetimez']);
            if ($date !== false) {
                if ($this->getPlacesAssets()->getFromDatetimez() !== null && $date < $this->getPlacesAssets()->getFromDatetimez()) {
                    $errored = true;
                    $error_message = ['until_datetimez' => 'needs to be after from'];
                }
                $this->getPlacesAssets()->setUntilDatetimez($date);
            } else {
                $errored = true;
                $error_message = ['until_datetimez' => 'needs to be a string in format d.m.Y'];
            }
        } elseif (isset($json_body['until_datetimez'])) {
            $errored = true;
            $error_message = ['until_datetimez' => 'needs to be a string in format d.m.Y'];
        }

        if (isset($json_body['pickup_datetimez']) && is_string($json_body['pickup_datetimez'])) {
            $date = DateTime::createFromFormat('d.m.Y', $json_body['pickup_datetimez']);
            if ($date !== false) {
                $this->getPlacesAssets()->setPickupDatetimez($date);
            } else {
                $errored = true;
                $error_message = ['pickup_datetimez' => 'needs to be a string in format d.m.Y'];
            }
        } elseif (isset($json_body['pickup_datetimez'])) {
            $errored = true;
            $error_message = ['pickup_datetimez' => 'needs to be a string in format d.m.Y'];
        }

        if (!$errored) {
            $id = $this->getPlacesAssets()->create();
            $this->getPlace()->updateLastChanged($this->getPlacesAssets()->getPlace());
            return new JsonResponse(['created' => true, 'id' => $id], 201);
        } else {
            return new JsonResponse(['created' => false, 'error' => $error_message], 400);
        }
    }

    /**
     * @return PlacesAssets
     */
    public function getPlacesAssets(): PlacesAssets
    {
        return $this->places_assets;
    }

    /**
     * @param PlacesAssets $places_assets
     * @return PlacesAssetsCreateHandler
     */
    public function setPlacesAssets(PlacesAssets $places_assets): PlacesAssetsCreateHandler
    {
        $this->places_assets = $places_assets;
        return $this;
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
     * @return PlacesAssetsCreateHandler
     */
    public function setAsset(Asset $asset): PlacesAssetsCreateHandler
    {
        $this->asset = $asset;
        return $this;
    }

    /**
     * @return Place
     */
    public function getPlace(): Place
    {
        return $this->place;
    }

    /**
     * @param Place $place
     * @return PlacesAssetsCreateHandler
     */
    public function setPlace(Place $place): PlacesAssetsCreateHandler
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @return User
     */
    public function getPerson(): User
    {
        return $this->person;
    }

    /**
     * @param User $person
     * @return PlacesAssetsCreateHandler
     */
    public function setPerson(User $person): PlacesAssetsCreateHandler
    {
        $this->person = $person;
        return $this;
    }
}

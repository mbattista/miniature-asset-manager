<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\CitrixNotFoundException;
use AssetManager\Models\Citrix;
use AssetManager\Models\Place;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlaceCreateHandler implements RequestHandlerInterface
{
    protected Place $place;
    protected Citrix $citrix;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;
        $error_message = [];

        $json_body = json_decode($request->getBody()->getContents(), true);
        if (isset($json_body['name']) && empty($json_body['name'])) {
            unset($json_body['name']);
        }
        if (isset($json_body['name']) && is_string($json_body['name'])) {
            $this->getPlace()->setName($json_body['name']);
        } elseif (isset($json_body['name'])) {
            $errored = true;
            $error_message = ['name' => 'needs to be string'];
        } else {
            $errored = true;
            $error_message = ['name' => 'required'];
        }

        if (isset($json_body['citrix']) && empty($json_body['citrix'])) {
            unset($json_body['citrix']);
        }
        if (isset($json_body['citrix']) && is_array($json_body['citrix'])) {
            try {
                foreach ($json_body['citrix'] as $item) {
                    $this->getCitrix()->get($item);
                }
                $this->getPlace()->setCitrix($json_body['citrix']);
            } catch (CitrixNotFoundException $e) {
                $errored = true;
                $error_message = ['citrix' => 'not exists'];
            }
        }

        if (isset($json_body['longitude']) && empty($json_body['longitude'])) {
            unset($json_body['longitude']);
        }
        if (isset($json_body['longitude']) && is_string($json_body['longitude'])) {
            $this->getPlace()->setLongitude($json_body['longitude']);
        } elseif (isset($json_body['longitude'])) {
            $errored = true;
            $error_message = ['longitude' => 'needs to be string'];
        }

        if (isset($json_body['latitude']) && empty($json_body['latitude'])) {
            unset($json_body['latitude']);
        }
        if (isset($json_body['latitude']) && is_string($json_body['latitude'])) {
            $this->getPlace()->setLatitude($json_body['latitude']);
        } elseif (isset($json_body['latitude'])) {
            $errored = true;
            $error_message = ['latitude' => 'needs to be string'];
        }

        if (isset($json_body['street']) && empty($json_body['street'])) {
            unset($json_body['street']);
        }
        if (isset($json_body['street']) && is_string($json_body['street'])) {
            $this->getPlace()->setStreet($json_body['street']);
        } elseif (isset($json_body['street'])) {
            $errored = true;
            $error_message = ['street' => 'needs to be string'];
        }

        if (isset($json_body['number']) && empty($json_body['number'])) {
            unset($json_body['number']);
        }
        if (isset($json_body['number']) && is_string($json_body['number'])) {
            $this->getPlace()->setNumber($json_body['number']);
        } elseif (isset($json_body['number'])) {
            $errored = true;
            $error_message = ['number' => 'needs to be string'];
        }

        if (isset($json_body['postcode']) && empty($json_body['postcode'])) {
            unset($json_body['postcode']);
        }
        if (isset($json_body['postcode']) && is_string($json_body['postcode'])) {
            $this->getPlace()->setPostcode($json_body['postcode']);
        } elseif (isset($json_body['postcode'])) {
            $errored = true;
            $error_message = ['postcode' => 'needs to be string'];
        }

        if (isset($json_body['city']) && empty($json_body['city'])) {
            unset($json_body['city']);
        }
        if (isset($json_body['city']) && is_string($json_body['city'])) {
            $this->getPlace()->setCity($json_body['city']);
        } elseif (isset($json_body['city'])) {
            $errored = true;
            $error_message = ['city' => 'needs to be string'];
        }

        if (isset($json_body['tel1']) && empty($json_body['tel1'])) {
            unset($json_body['tel1']);
        }
        if (isset($json_body['tel1']) && is_string($json_body['tel1'])) {
            $this->getPlace()->setTel1($json_body['tel1']);
        } elseif (isset($json_body['tel1'])) {
            $errored = true;
            $error_message = ['tel1' => 'needs to be string'];
        }

        if (isset($json_body['tel2']) && empty($json_body['tel2'])) {
            unset($json_body['tel2']);
        }
        if (isset($json_body['tel2']) && is_string($json_body['tel2'])) {
            $this->getPlace()->setTel2($json_body['tel2']);
        } elseif (isset($json_body['tel2'])) {
            $errored = true;
            $error_message = ['tel2' => 'needs to be string'];
        }

        if (isset($json_body['tel3']) && empty($json_body['tel3'])) {
            unset($json_body['tel3']);
        }
        if (isset($json_body['tel3']) && is_string($json_body['tel3'])) {
            $this->getPlace()->setTel3($json_body['tel3']);
        } elseif (isset($json_body['tel3'])) {
            $errored = true;
            $error_message = ['tel3' => 'needs to be string'];
        }

        if (isset($json_body['tel4']) && empty($json_body['tel4'])) {
            unset($json_body['tel4']);
        }
        if (isset($json_body['tel4']) && is_string($json_body['tel4'])) {
            $this->getPlace()->setTel4($json_body['tel4']);
        } elseif (isset($json_body['tel4'])) {
            $errored = true;
            $error_message = ['tel4' => 'needs to be string'];
        }

        if (isset($json_body['fax']) && empty($json_body['fax'])) {
            unset($json_body['fax']);
        }
        if (isset($json_body['fax']) && is_string($json_body['fax'])) {
            $this->getPlace()->setFax($json_body['fax']);
        } elseif (isset($json_body['fax'])) {
            $errored = true;
            $error_message = ['fax' => 'needs to be string'];
        }

        if (isset($json_body['opening_times']) && empty($json_body['opening_times'])) {
            unset($json_body['opening_times']);
        }
        if (isset($json_body['opening_times']) && is_string($json_body['opening_times'])) {
            $this->getPlace()->setOpeningTimes($json_body['opening_times']);
        } elseif (isset($json_body['opening_times'])) {
            $errored = true;
            $error_message = ['opening_times' => 'needs to be string'];
        }

        if (isset($json_body['website']) && empty($json_body['website'])) {
            unset($json_body['website']);
        }
        if (isset($json_body['website']) && is_string($json_body['website'])) {
            $this->getPlace()->setWebsite($json_body['website']);
        } elseif (isset($json_body['website'])) {
            $errored = true;
            $error_message = ['website' => 'needs to be string'];
        }

        if (isset($json_body['email']) && empty($json_body['email'])) {
            unset($json_body['email']);
        }
        if (isset($json_body['email']) && is_string($json_body['email'])) {
            $this->getPlace()->setEmail($json_body['email']);
        } elseif (isset($json_body['email'])) {
            $errored = true;
            $error_message = ['email' => 'needs to be string'];
        }

        if (isset($json_body['text']) && empty($json_body['text'])) {
            unset($json_body['text']);
        }
        if (isset($json_body['text']) && is_string($json_body['text'])) {
            $this->getPlace()->setText($json_body['text']);
        } elseif (isset($json_body['text'])) {
            $errored = true;
            $error_message = ['text' => 'needs to be string'];
        }

        if (isset($json_body['active']) && is_bool($json_body['active'])) {
            $this->getPlace()->setActive((bool)$json_body['active']);
        } elseif (isset($json_body['active'])) {
            $errored = true;
            $error_message = ['active' => 'needs to be boolean'];
        }

        if (!$errored) {
            $id = $this->getPlace()->create();
            return new JsonResponse(['created' => true, 'id' => $id], 201);
        } else {
            return new JsonResponse(['created' => false, 'error' => $error_message], 400);
        }
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
     * @return PlaceCreateHandler
     */
    public function setPlace(Place $place): PlaceCreateHandler
    {
        $this->place = $place;
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
     * @return PlaceCreateHandler
     */
    public function setCitrix(Citrix $citrix): PlaceCreateHandler
    {
        $this->citrix = $citrix;
        return $this;
    }
}

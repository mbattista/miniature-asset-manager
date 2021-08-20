<?php
declare(strict_types=1);

namespace AssetManager\Handler;

use AssetManager\Error\PersonNotFoundException;
use AssetManager\Error\PlaceNotFoundException;
use AssetManager\Models\Enduser;
use AssetManager\Models\Person;
use AssetManager\Models\Place;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EndUserUpdateHandler implements RequestHandlerInterface
{
    protected Enduser $end_user;
    protected Place $place;
    protected Person $person;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $errored = false;
        $error_message = [];

        $json_body = json_decode($request->getBody()->getContents(), true);

        $id = (int)$request->getAttribute('end_user');
        $this->getEndUser()->get($id);

        if (isset($json_body['person']) && empty($json_body['person'])) {
            unset($json_body['person']);
        }
        if (isset($json_body['person']) && is_int($json_body['person'])) {
            try {
                $this->getPerson()->get($json_body['person']);
                $this->getEndUser()->setPerson($json_body['person']);
            } catch (PersonNotFoundException $e) {
                $errored = true;
                $error_message = ['person' => 'not exists'];
            }
        } elseif (isset($json_body['person'])) {
            $errored = true;
            $error_message = ['person' => 'needs to be integer'];
        } else {
            $errored = true;
            $error_message = ['person' => 'required'];
        }

        if (isset($json_body['place']) && empty($json_body['place'])) {
            unset($json_body['place']);
        }
        if (isset($json_body['place']) && is_int($json_body['place'])) {
            try {
                $this->getPlace()->get($json_body['place']);
                $this->getEndUser()->setPlace($json_body['place']);
            } catch (PlaceNotFoundException $e) {
                $errored = true;
                $error_message = ['place' => 'not exists'];
            }
        } elseif (isset($json_body['place'])) {
            $errored = true;
            $error_message = ['place' => 'needs to be integer'];
        } else {
            $this->getEndUser()->setPlace(null);
        }

        if (isset($json_body['active']) && empty($json_body['active'])) {
            unset($json_body['active']);
        }
        if (isset($json_body['active']) && is_bool($json_body['active'])) {
            $this->getEndUser()->setActive($json_body['active']);
        } elseif (isset($json_body['active'])) {
            $errored = true;
            $error_message = ['active' => 'needs to be boolean'];
        } else {
            $this->getEndUser()->setActive(false);
        }

        if (isset($json_body['text']) && empty($json_body['text'])) {
            unset($json_body['text']);
        }
        if (isset($json_body['text']) && is_string($json_body['text'])) {
            $this->getEndUser()->setText($json_body['text']);
        } elseif (isset($json_body['text'])) {
            $errored = true;
            $error_message = ['text' => 'needs to be string'];
        } else {
            $this->getEndUser()->setText(null);
        }

        if (isset($json_body['tel']) && empty($json_body['tel'])) {
            unset($json_body['tel']);
        }
        if (isset($json_body['tel']) && is_string($json_body['tel'])) {
            $this->getEndUser()->setTel($json_body['tel']);
        } elseif (isset($json_body['tel'])) {
            $errored = true;
            $error_message = ['tel' => 'needs to be string'];
        } else {
            $this->getEndUser()->setTel(null);
        }

        if (isset($json_body['mobile']) && empty($json_body['mobile'])) {
            unset($json_body['mobile']);
        }
        if (isset($json_body['mobile']) && is_string($json_body['mobile'])) {
            $this->getEndUser()->setMobile($json_body['mobile']);
        } elseif (isset($json_body['mobile'])) {
            $errored = true;
            $error_message = ['mobile' => 'needs to be string'];
        } else {
            $this->getEndUser()->setMobile(null);
        }

        if (isset($json_body['email']) && empty($json_body['mobile'])) {
            unset($json_body['email']);
        }
        if (isset($json_body['email']) && is_string($json_body['email'])) {
            $this->getEndUser()->setEmail($json_body['email']);
        } elseif (isset($json_body['email'])) {
            $errored = true;
            $error_message = ['email' => 'needs to be string'];
        } else {
            $this->getEndUser()->setEmail(null);
        }

        if (!$errored) {
            $this->getEndUser()->update();
            return new JsonResponse(['updated' => true]);
        } else {
            return new JsonResponse(['updated' => false, 'error' => $error_message], 400);
        }
    }

    /**
     * @return Enduser
     */
    public function getEndUser(): Enduser
    {
        return $this->end_user;
    }

    /**
     * @param Enduser $end_user
     * @return EndUserUpdateHandler
     */
    public function setEndUser(Enduser $end_user): EndUserUpdateHandler
    {
        $this->end_user = $end_user;
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
     * @return EndUserUpdateHandler
     */
    public function setPlace(Place $place): EndUserUpdateHandler
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     * @return EndUserUpdateHandler
     */
    public function setPerson(Person $person): EndUserUpdateHandler
    {
        $this->person = $person;
        return $this;
    }
}

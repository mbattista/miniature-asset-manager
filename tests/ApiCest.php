<?php

declare(strict_types=1);

namespace AssetManagerTest;

use ApiTester;

class ApiCest
{
    public function listAssets(ApiTester $I)
    {
        $I->sendGET('/asset');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listAssetsSearch(ApiTester $I)
    {
        $I->sendGET('/asset?q=t');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getAsset(ApiTester $I)
    {
        $I->sendGET('/asset/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function createAssetMinimal(ApiTester $I)
    {
        $data = [];
        $I->sendPOST('/asset', $data);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function createAssetFull(ApiTester $I)
    {
        $data = [
            'name' => 'codecept_name',
            'serial' => 'codecept_serial',
            'active' => true,
            'type' => 'codecept_type',
            'out_of_order' => false,
            'text' => 'codecept_text',
            'is_owned_by' => 'codecept_iob',
        ];
        $I->sendPOST('/asset', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function updateAsset(ApiTester $I)
    {
        $I->sendGET('/asset?q=codecept_name');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $data = [
            'name' => 'codecept_update_name',
            'serial' => 'codecept_update_serial',
            'active' => false,
            'type' => 'codecept_update_type',
            'out_of_order' => true,
            'text' => 'codecept_update_text',
            'is_owned_by' => 'codecept_update_iob',
        ];

        $I->sendPUT('/asset/' . $id, json_encode($data));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deleteAssets(ApiTester $I)
    {
        $I->sendGET('/asset?q=codecept_update_name');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $I->sendDELETE('/asset/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDELETE('/asset/' . ($id - 1));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listPlaces(ApiTester $I)
    {
        $I->sendGET('/place');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listPlacesSearch(ApiTester $I)
    {
        $I->sendGET('/place?q=t');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getPlace(ApiTester $I)
    {
        $I->sendGET('/place/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function createPlaceMinimal(ApiTester $I)
    {
        $data = [
            'active' => true,
        ];
        $I->sendPOST('/place', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function createPlaceFull(ApiTester $I)
    {
        $data = [
            'name' => 'codecept_name',
            'longitude' => 'codecept_longitude',
            'latitude' => 'codecept_latitude',
            'street' => 'codecept_street',
            'number' => 'codecept_number',
            'postcode' => 'codecept_postcode',
            'city' => 'codecept_city',
            'tel1' => 'codecept_tel1',
            'tel2' => 'codecept_tel2',
            'tel3' => 'codecept_tel3',
            'tel4' => 'codecept_tel4',
            'fax' => 'codecept_fax',
            'opening_times' => 'codecept_opening_times',
            'website' => 'codecept_website',
            'email' => 'codecept_email',
            'text' => 'codecept_text',
            'active' => false,
        ];
        $I->sendPOST('/place', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function updatePlace(ApiTester $I)
    {
        $I->sendGET('/place?q=codecept_name');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $data = [
            'name' => 'codecept_update_name',
            'longitude' => 'codecept_update_longitude',
            'latitude' => 'codecept_update_latitude',
            'street' => 'codecept_update_street',
            'number' => 'codecept_update_number',
            'postcode' => 'codecept_update_postcode',
            'city' => 'codecept_update_city',
            'tel1' => 'codecept_update_tel1',
            'tel2' => 'codecept_update_tel2',
            'tel3' => 'codecept_update_tel3',
            'tel4' => 'codecept_update_tel4',
            'fax' => 'codecept_update_fax',
            'opening_update_times' => 'codecept_update_opening_update_times',
            'website' => 'codecept_update_website',
            'email' => 'codecept_update_email',
            'text' => 'codecept_update_text',
            'active' => false,
        ];

        $I->sendPUT('/place/' . $id, json_encode($data));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deletePlaces(ApiTester $I)
    {
        $I->sendGET('/place?q=codecept_update_name');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $I->sendDELETE('/place/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDELETE('/place/' . ($id - 1));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listPersons(ApiTester $I)
    {
        $I->sendGET('/person');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listPersonsSearch(ApiTester $I)
    {
        $I->sendGET('/person?q=t');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getPerson(ApiTester $I)
    {
        $I->sendGET('/person/6');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function createPersonMinimal(ApiTester $I)
    {
        $data = [];
        $I->sendPOST('/person', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function createPersonFull(ApiTester $I)
    {
        $data = [
            'last_name' => 'codecept_name',
            'first_name' => 'codecept_fist_name',
        ];
        $I->sendPOST('/person', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function updatePerson(ApiTester $I)
    {
        $I->sendGET('/person?q=codecept_name');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $data = [
            'last_name' => 'codecept_update_name',
            'first_name' => 'codecept_update_fist_name',
        ];

        $I->sendPUT('/person/' . $id, json_encode($data));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deletePersons(ApiTester $I)
    {
        $I->sendGET('/person?q=codecept_update_name');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $I->sendDELETE('/person/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDELETE('/person/' . ($id - 1));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listUsers(ApiTester $I)
    {
        $I->sendGET('/user');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listUsersSearch(ApiTester $I)
    {
        $I->sendGET('/user?q=t');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getUser(ApiTester $I)
    {
        $I->sendGET('/user/8');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function createUserMinimal(ApiTester $I)
    {
        $data = [
            'email' => 'codecept@example.com',
            'password' => 'codecept_password',
            'person' => 6,
        ];
        $I->sendPOST('/user', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function createUserFull(ApiTester $I)
    {
        $data = [
            'email' => 'codecept_email@example.com',
            'password' => 'codecept_password',
            'person' => 6,
            'deactivated' => true,
        ];
        $I->sendPOST('/user', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function updateUser(ApiTester $I)
    {
        $I->sendGET('/user?q=codecept_email@example.com');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $data = [
            'email' => 'codecept_update_email@example.com',
            'person' => 6,
            'deactivated' => false,
        ];

        $I->sendPUT('/user/' . $id, json_encode($data));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deleteUsers(ApiTester $I)
    {
        $I->sendGET('/user?q=codecept_update_email@example.com');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $I->sendDELETE('/user/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDELETE('/user/' . ($id - 1));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listEndUsers(ApiTester $I)
    {
        $I->sendGET('/end_user');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listEndUsersSearch(ApiTester $I)
    {
        $I->sendGET('/end_user?q=t');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listEndUsersPerPlace(ApiTester $I)
    {
        $I->sendGET('/end_user?q=t&place=1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listEndUsersPerPerson(ApiTester $I)
    {
        $I->sendGET('/end_user?q=t&person=1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listEndUsersPerAssetAndPerson(ApiTester $I)
    {
        $I->sendGET('/end_user?q=t&person=1&place=1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getEndUser(ApiTester $I)
    {
        $I->sendGET('/end_user/16');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function createEndUserMinimal(ApiTester $I)
    {
        $data = [
            'person' => 6,
        ];
        $I->sendPOST('/end_user', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function createEndUserFull(ApiTester $I)
    {
        $data = [
            'person' => 6,
            'place' => 1,
            'active' => true,
            'citrix' => 'codecept_citrix',
            'teamviewer_id' => 'codecept_teamviewer',
            'tel' => 'codecept_tel',
            'mobile' => 'codecept_mobile',
            'email' => 'codecept_email@example.com',
        ];
        $I->sendPOST('/end_user', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function updateEndUser(ApiTester $I)
    {
        $I->sendGET('/end_user?q=codecept_email@example.com');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $data = [
            'person' => 6,
            'place' => 1,
            'active' => false,
            'citrix' => 'codecept_update_citrix',
            'teamviewer_id' => 'codecept_update_teamviewer',
            'tel' => 'codecept_update_tel',
            'mobile' => 'codecept_update_mobile',
            'email' => 'codecept_update_email@example.com',
        ];

        $I->sendPUT('/end_user/' . $id, json_encode($data));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deleteEndUsers(ApiTester $I)
    {
        $I->sendGET('/end_user?q=codecept_update_email@example.com');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $I->sendDELETE('/end_user/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDELETE('/end_user/' . ($id - 1));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listPlacesAssets(ApiTester $I)
    {
        $I->sendGET('/places_assets');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listPlacesAssetsSearch(ApiTester $I)
    {
        $I->sendGET('/places_assets?q=t');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getPlacesAssets(ApiTester $I)
    {
        $I->sendGET('/places_assets/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function createPlacesAssetsMinimal(ApiTester $I)
    {
        $data = [
            'place' => 1,
            'asset' => 1,
        ];
        $I->sendPOST('/places_assets', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function createPlacesAssetsFull(ApiTester $I)
    {
        $data = [
            'asset' => 1,
            'place' => 1,
            'deliverer_person' => 6,
            'receiver_person' => 6,
            'pickup_person_id' => 6,
            'pickup_responsible_person_id' => 6,
            'automatic_callback' => false,
            'text' => 'codecept_email@example.com',
            'delivery_datetimez' => '01.01.2021 15:00:00',
            'from_datetimez' => '01.02.2021 15:00:00',
            'until_datetimez' => '01.03.2021 15:00:00',
            'pickup_datetimez' => '01.04.2021 15:00:00',
        ];
        $I->sendPOST('/places_assets', json_encode($data));
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function updatePlacesAssets(ApiTester $I)
    {
        $I->sendGET('/places_assets?q=codecept_email@example.com');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $data = [
            'asset' => 1,
            'place' => 1,
            'deliverer_person' => 6,
            'receiver_person' => 6,
            'pickup_person_id' => 6,
            'pickup_responsible_person_id' => 6,
            'automatic_callback' => false,
            'text' => 'codecept_update_email@example.com',
            'delivery_datetimez' => '02.01.2021 15:00:00',
            'from_datetimez' => '02.02.2021 15:00:00',
            'until_datetimez' => '02.03.2021 15:00:00',
            'pickup_datetimez' => '02.04.2021 15:00:00',
        ];

        $I->sendPUT('/places_assets/' . $id, json_encode($data));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deletePlacesAssets(ApiTester $I)
    {
        $I->sendGET('/places_assets?q=codecept_update_email@example.com');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $message = (array)json_decode($I->grabResponse(), true);
        $id = $message[0]['id'];

        $I->sendDELETE('/places_assets/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendDELETE('/places_assets/' . ($id - 1));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}

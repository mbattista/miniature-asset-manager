<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', AssetManager\Handler\DashboardHandler::class, 'dashboard');

    $app->get('/asset', AssetManager\Handler\AssetOverviewHandler::class, 'asset-overview');
    $app->post('/asset', AssetManager\Handler\AssetCreateHandler::class, 'asset-create');
    $app->get('/asset/{asset}', AssetManager\Handler\AssetDetailHandler::class, 'asset-detail');
    $app->put('/asset/{asset}', AssetManager\Handler\AssetUpdateHandler::class, 'asset-update');
    $app->delete('/asset/{asset}', AssetManager\Handler\AssetDeleteHandler::class, 'asset-delete');

    $app->get('/place', AssetManager\Handler\PlaceOverviewHandler::class, 'place-overview');
    $app->post('/place', AssetManager\Handler\PlaceCreateHandler::class, 'place-create');
    $app->get('/place/{place}', AssetManager\Handler\PlaceDetailHandler::class, 'place-detail');
    $app->put('/place/{place}', AssetManager\Handler\PlaceUpdateHandler::class, 'place-update');
    $app->delete('/place/{place}', AssetManager\Handler\PlaceDeleteHandler::class, 'place-delete');
    $app->get('/place_detail', AssetManager\Handler\PlaceDetailOverviewHandler::class, 'place-detail-overview');

    $app->get('/person', AssetManager\Handler\PersonOverviewHandler::class, 'person-overview');
    $app->post('/person', AssetManager\Handler\PersonCreateHandler::class, 'person-create');
    $app->get('/person/{person}', AssetManager\Handler\PersonDetailHandler::class, 'person-detail');
    $app->put('/person/{person}', AssetManager\Handler\PersonUpdateHandler::class, 'person-update');
    $app->delete('/person/{person}', AssetManager\Handler\PersonDeleteHandler::class, 'person-delete');

    $app->get('/user', AssetManager\Handler\AssetUserOverviewHandler::class, 'user-overview');
    $app->post('/user', AssetManager\Handler\AssetUserCreateHandler::class, 'user-create');
    $app->get('/user/{user}', AssetManager\Handler\AssetUserDetailHandler::class, 'user-detail');
    $app->put('/user/{user}', AssetManager\Handler\AssetUserUpdateHandler::class, 'user-update');
    $app->delete('/user/{user}', AssetManager\Handler\AssetUserDeleteHandler::class, 'user-delete');

    $app->get('/end_user', AssetManager\Handler\EndUserOverviewHandler::class, 'end-user-overview');
    $app->post('/end_user', AssetManager\Handler\EndUserCreateHandler::class, 'end-user-create');
    $app->get('/end_user/{end_user}', AssetManager\Handler\EndUserDetailHandler::class, 'end-user-detail');
    $app->put('/end_user/{end_user}', AssetManager\Handler\EndUserUpdateHandler::class, 'end-user-update');
    $app->delete('/end_user/{end_user}', AssetManager\Handler\EndUserDeleteHandler::class, 'end-user-delete');

    $app->get('/citrix_assets', AssetManager\Handler\AssetCitrixOverviewHandler::class, 'citrix-assets-overview');

    $app->get('/places_assets', AssetManager\Handler\PlacesAssetsOverviewHandler::class, 'places-assets-overview');
    $app->post('/places_assets', AssetManager\Handler\PlacesAssetsCreateHandler::class, 'places-assets-create');
    $app->get('/places_assets/{places_assets}', AssetManager\Handler\PlacesAssetsDetailHandler::class, 'places-assets-detail');
    $app->put('/places_assets/{places_assets}', AssetManager\Handler\PlacesAssetsUpdateHandler::class, 'places-assets-update');
    $app->delete('/places_assets/{places_assets}', AssetManager\Handler\PlacesAssetsDeleteHandler::class, 'places-assets-delete');

    $app->get('/external_person', AssetManager\Handler\PlacesAssetsExternalPersonOverviewHandler::class, 'external-person-overview');

    $app->get('/external_person/places_assets', AssetManager\Handler\ExternalPersonPlacesAssetsOverviewHandler::class, 'external-person-places-assets-overview');

    $app->get('/citrix', AssetManager\Handler\CitrixOverviewHandler::class, 'citrix-overview');
    $app->post('/citrix', AssetManager\Handler\CitrixCreateHandler::class, 'citrix-create');
    $app->get('/citrix/{citrix}', AssetManager\Handler\CitrixDetailHandler::class, 'citrix-detail');
    $app->put('/citrix/{citrix}', AssetManager\Handler\CitrixUpdateHandler::class, 'citrix-update');
    $app->delete('/citrix/{citrix}', AssetManager\Handler\CitrixDeleteHandler::class, 'citrix-delete');

    $app->get('/asset_type', AssetManager\Handler\AssetTypeOverviewHandler::class, 'asset-type-overview');
    $app->get('/asset_name', AssetManager\Handler\AssetNameOverviewHandler::class, 'asset-name-overview');
    $app->get('/search', AssetManager\Handler\SearchOverviewHandler::class, 'search-overview');
    $app->post('/login', AssetManager\Handler\LoginHandler::class, 'login-create');
    $app->get('/logout', AssetManager\Handler\LogoutHandler::class, 'logout-detail');

    $app->put('/preference/{user}', AssetManager\Handler\PreferenceUpdateHandler::class, 'preference-update');
};

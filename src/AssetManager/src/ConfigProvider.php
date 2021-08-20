<?php
declare(strict_types=1);

namespace AssetManager;

use AssetManager\ErrorHandling\ErrorHandlerFactory;
use AssetManager\ErrorHandling\JsonErrorResponseGenerator;
use AssetManager\ErrorHandling\JsonErrorResponseGeneratorFactory;
use AssetManager\ErrorHandling\LoggingErrorListenerDelegatorFactory;
use AssetManager\Handler\AssetCitrixOverviewHandler;
use AssetManager\Handler\AssetCreateHandler;
use AssetManager\Handler\AssetDeleteHandler;
use AssetManager\Handler\AssetDetailHandler;
use AssetManager\Handler\AssetNameOverviewHandler;
use AssetManager\Handler\AssetOverviewHandler;
use AssetManager\Handler\AssetTypeOverviewHandler;
use AssetManager\Handler\AssetUpdateHandler;
use AssetManager\Handler\AssetUserCreateHandler;
use AssetManager\Handler\AssetUserDeleteHandler;
use AssetManager\Handler\AssetUserDetailHandler;
use AssetManager\Handler\AssetUserOverviewHandler;
use AssetManager\Handler\AssetUserUpdateHandler;
use AssetManager\Handler\CitrixCreateHandler;
use AssetManager\Handler\CitrixDeleteHandler;
use AssetManager\Handler\CitrixDetailHandler;
use AssetManager\Handler\CitrixOverviewHandler;
use AssetManager\Handler\CitrixUpdateHandler;
use AssetManager\Handler\DashboardHandler;
use AssetManager\Handler\EndUserCreateHandler;
use AssetManager\Handler\EndUserDeleteHandler;
use AssetManager\Handler\EndUserDetailHandler;
use AssetManager\Handler\EndUserOverviewHandler;
use AssetManager\Handler\EndUserUpdateHandler;
use AssetManager\Handler\ExternalPersonPlacesAssetsOverviewHandler;
use AssetManager\Handler\Factory\AssetCitrixOverviewHandlerFactory;
use AssetManager\Handler\Factory\AssetCreateHandlerFactory;
use AssetManager\Handler\Factory\AssetDeleteHandlerFactory;
use AssetManager\Handler\Factory\AssetDetailHandlerFactory;
use AssetManager\Handler\Factory\AssetNameOverviewHandlerFactory;
use AssetManager\Handler\Factory\AssetOverviewHandlerFactory;
use AssetManager\Handler\Factory\AssetTypeOverviewHandlerFactory;
use AssetManager\Handler\Factory\AssetUpdateHandlerFactory;
use AssetManager\Handler\Factory\AssetUserCreateHandlerFactory;
use AssetManager\Handler\Factory\AssetUserDeleteHandlerFactory;
use AssetManager\Handler\Factory\AssetUserDetailHandlerFactory;
use AssetManager\Handler\Factory\AssetUserOverviewHandlerFactory;
use AssetManager\Handler\Factory\AssetUserUpdateHandlerFactory;
use AssetManager\Handler\Factory\CitrixCreateHandlerFactory;
use AssetManager\Handler\Factory\CitrixDeleteHandlerFactory;
use AssetManager\Handler\Factory\CitrixDetailHandlerFactory;
use AssetManager\Handler\Factory\CitrixOverviewHandlerFactory;
use AssetManager\Handler\Factory\CitrixUpdateHandlerFactory;
use AssetManager\Handler\Factory\DashboardHandlerFactory;
use AssetManager\Handler\Factory\EndUserCreateHandlerFactory;
use AssetManager\Handler\Factory\EndUserDeleteHandlerFactory;
use AssetManager\Handler\Factory\EndUserDetailHandlerFactory;
use AssetManager\Handler\Factory\EndUserOverviewHandlerFactory;
use AssetManager\Handler\Factory\EndUserUpdateHandlerFactory;
use AssetManager\Handler\Factory\ExternalPersonPlacesAssetsOverviewHandlerFactory;
use AssetManager\Handler\Factory\LoginHandlerFactory;
use AssetManager\Handler\Factory\LogoutHandlerFactory;
use AssetManager\Handler\Factory\PersonCreateHandlerFactory;
use AssetManager\Handler\Factory\PersonDeleteHandlerFactory;
use AssetManager\Handler\Factory\PersonDetailHandlerFactory;
use AssetManager\Handler\Factory\PersonOverviewHandlerFactory;
use AssetManager\Handler\Factory\PersonUpdateHandlerFactory;
use AssetManager\Handler\Factory\PlaceCreateHandlerFactory;
use AssetManager\Handler\Factory\PlaceDeleteHandlerFactory;
use AssetManager\Handler\Factory\PlaceDetailHandlerFactory;
use AssetManager\Handler\Factory\PlaceDetailOverviewHandlerFactory;
use AssetManager\Handler\Factory\PlaceOverviewHandlerFactory;
use AssetManager\Handler\Factory\PlacesAssetsCreateHandlerFactory;
use AssetManager\Handler\Factory\PlacesAssetsDeleteHandlerFactory;
use AssetManager\Handler\Factory\PlacesAssetsDetailHandlerFactory;
use AssetManager\Handler\Factory\PlacesAssetsExternalPersonOverviewHandlerFactory;
use AssetManager\Handler\Factory\PlacesAssetsOverviewHandlerFactory;
use AssetManager\Handler\Factory\PlacesAssetsUpdateHandlerFactory;
use AssetManager\Handler\Factory\PlaceUpdateHandlerFactory;
use AssetManager\Handler\Factory\PreferenceUpdateHandlerFactory;
use AssetManager\Handler\Factory\SearchOverviewHandlerFactory;
use AssetManager\Handler\LoginHandler;
use AssetManager\Handler\LogoutHandler;
use AssetManager\Handler\PersonCreateHandler;
use AssetManager\Handler\PersonDeleteHandler;
use AssetManager\Handler\PersonDetailHandler;
use AssetManager\Handler\PersonOverviewHandler;
use AssetManager\Handler\PersonUpdateHandler;
use AssetManager\Handler\PlaceCreateHandler;
use AssetManager\Handler\PlaceDeleteHandler;
use AssetManager\Handler\PlaceDetailHandler;
use AssetManager\Handler\PlaceDetailOverviewHandler;
use AssetManager\Handler\PlaceOverviewHandler;
use AssetManager\Handler\PlacesAssetsCreateHandler;
use AssetManager\Handler\PlacesAssetsDeleteHandler;
use AssetManager\Handler\PlacesAssetsDetailHandler;
use AssetManager\Handler\PlacesAssetsExternalPersonOverviewHandler;
use AssetManager\Handler\PlacesAssetsOverviewHandler;
use AssetManager\Handler\PlacesAssetsUpdateHandler;
use AssetManager\Handler\PlaceUpdateHandler;
use AssetManager\Handler\PreferenceUpdateHandler;
use AssetManager\Handler\SearchOverviewHandler;
use AssetManager\Helper\DbHelper;
use AssetManager\Helper\Factory\DbHelperFactory;
use AssetManager\Middleware\CorsMiddleware;
use AssetManager\Middleware\Factory\CorsMiddlewareFactory;
use AssetManager\Middleware\Factory\LoginMiddlewareFactory;
use AssetManager\Middleware\Factory\RestErrorCatcherMiddlewareFactory;
use AssetManager\Middleware\LoginMiddleware;
use AssetManager\Middleware\RestErrorCatcherMiddleware;
use AssetManager\Models\Asset;
use AssetManager\Models\Citrix;
use AssetManager\Models\Enduser;
use AssetManager\Models\Factory\AssetFactory;
use AssetManager\Models\Factory\CitrixFactory;
use AssetManager\Models\Factory\EndUserFactory;
use AssetManager\Models\Factory\PersonFactory;
use AssetManager\Models\Factory\PlaceFactory;
use AssetManager\Models\Factory\PlacesAssetsFactory;
use AssetManager\Models\Factory\UserFactory;
use AssetManager\Models\Person;
use AssetManager\Models\Place;
use AssetManager\Models\PlacesAssets;
use AssetManager\Models\User;
use Laminas\Log\LoggerAbstractServiceFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'delegators' => [
                ErrorHandler::class => [
                    LoggingErrorListenerDelegatorFactory::class,
                ],
            ],
            'factories'  => [
                ErrorHandler::class => ErrorHandlerFactory::class,
                JsonErrorResponseGenerator::class => JsonErrorResponseGeneratorFactory::class,
                DashboardHandler::class => DashboardHandlerFactory::class,
                LoginMiddleware::class => LoginMiddlewareFactory::class,
                CorsMiddleware::class => CorsMiddlewareFactory::class,
                DbHelper::class => DbHelperFactory::class,
                RestErrorCatcherMiddleware::class => RestErrorCatcherMiddlewareFactory::class,

                Asset::class => AssetFactory::class,
                Enduser::class => EndUserFactory::class,
                Person::class => PersonFactory::class,
                Place::class => PlaceFactory::class,
                User::class => UserFactory::class,
                PlacesAssets::class => PlacesAssetsFactory::class,
                Citrix::class => CitrixFactory::class,

                AssetCitrixOverviewHandler::class => AssetCitrixOverviewHandlerFactory::class,
                AssetOverviewHandler::class => AssetOverviewHandlerFactory::class,
                AssetDetailHandler::class => AssetDetailHandlerFactory::class,
                AssetCreateHandler::class => AssetCreateHandlerFactory::class,
                AssetUpdateHandler::class => AssetUpdateHandlerFactory::class,
                AssetDeleteHandler::class => AssetDeleteHandlerFactory::class,

                AssetUserOverviewHandler::class => AssetUserOverviewHandlerFactory::class,
                AssetUserDetailHandler::class => AssetUserDetailHandlerFactory::class,
                AssetUserUpdateHandler::class => AssetUserUpdateHandlerFactory::class,
                AssetUserDeleteHandler::class => AssetUserDeleteHandlerFactory::class,
                AssetUserCreateHandler::class => AssetUserCreateHandlerFactory::class,

                EndUserOverviewHandler::class => EndUserOverviewHandlerFactory::class,
                EndUserDetailHandler::class => EndUserDetailHandlerFactory::class,
                EndUserUpdateHandler::class => EndUserUpdateHandlerFactory::class,
                EndUserDeleteHandler::class => EndUserDeleteHandlerFactory::class,
                EndUserCreateHandler::class => EndUserCreateHandlerFactory::class,

                PersonOverviewHandler::class => PersonOverviewHandlerFactory::class,
                PersonDetailHandler::class => PersonDetailHandlerFactory::class,
                PersonCreateHandler::class => PersonCreateHandlerFactory::class,
                PersonUpdateHandler::class => PersonUpdateHandlerFactory::class,
                PersonDeleteHandler::class => PersonDeleteHandlerFactory::class,

                PlaceCreateHandler::class => PlaceCreateHandlerFactory::class,
                PlaceDeleteHandler::class => PlaceDeleteHandlerFactory::class,
                PlaceDetailHandler::class => PlaceDetailHandlerFactory::class,
                PlaceOverviewHandler::class => PlaceOverviewHandlerFactory::class,
                PlaceUpdateHandler::class => PlaceUpdateHandlerFactory::class,
                PlaceDetailOverviewHandler::class => PlaceDetailOverviewHandlerFactory::class,

                PlacesAssetsCreateHandler::class => PlacesAssetsCreateHandlerFactory::class,
                PlacesAssetsDeleteHandler::class => PlacesAssetsDeleteHandlerFactory::class,
                PlacesAssetsDetailHandler::class => PlacesAssetsDetailHandlerFactory::class,
                PlacesAssetsOverviewHandler::class => PlacesAssetsOverviewHandlerFactory::class,
                PlacesAssetsUpdateHandler::class => PlacesAssetsUpdateHandlerFactory::class,

                CitrixCreateHandler::class => CitrixCreateHandlerFactory::class,
                CitrixDeleteHandler::class => CitrixDeleteHandlerFactory::class,
                CitrixDetailHandler::class => CitrixDetailHandlerFactory::class,
                CitrixOverviewHandler::class => CitrixOverviewHandlerFactory::class,
                CitrixUpdateHandler::class => CitrixUpdateHandlerFactory::class,

                PreferenceUpdateHandler::class => PreferenceUpdateHandlerFactory::class,

                AssetTypeOverviewHandler::class => AssetTypeOverviewHandlerFactory::class,
                AssetNameOverviewHandler::class => AssetNameOverviewHandlerFactory::class,
                PlacesAssetsExternalPersonOverviewHandler::class => PlacesAssetsExternalPersonOverviewHandlerFactory::class,
                ExternalPersonPlacesAssetsOverviewHandler::class => ExternalPersonPlacesAssetsOverviewHandlerFactory::class,
                SearchOverviewHandler::class => SearchOverviewHandlerFactory::class,
                LoginHandler::class => LoginHandlerFactory::class,
                LogoutHandler::class => LogoutHandlerFactory::class,
            ],
            'abstract_factories' => [
                LoggerAbstractServiceFactory::class,
            ],
        ];
    }
}

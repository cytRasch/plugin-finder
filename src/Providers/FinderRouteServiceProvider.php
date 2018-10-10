<?php

namespace Finder\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;


class FinderRouteServiceProvider extends RouteServiceProvider {

    public function register() {

    }

    public function map(ApiRouter $apiRouter) {

        $apiRouter->version(['v1'], [], function ($router) {

            $router->get('finder', 'Finder\Controllers\FinderController@index');

        });

    }

}
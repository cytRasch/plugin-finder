<?php

namespace Finder\Providers;


use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;


/**
 * Class FinderRouteServiceProvider
 *
 * @author  raschi
 * @package Finder\Providers
 */
class FinderRouteServiceProvider extends RouteServiceProvider
{

    /**
     * Generic method
     */
    public function register()
    {

    }


    /**
     * @param \Plenty\Plugin\Routing\ApiRouter $apiRouter
     */
    public function map( ApiRouter $apiRouter )
    {

        $apiRouter->version(['v1'], [], function ( $router )
        {
            $router->get('finder', 'Finder\Controllers\FinderController@index');
            $router->get('finder/category{category}', 'Finder\Controllers\FinderController@show');

            $router->get('finder/items', 'Finder\Controllers\ItemCountController@index');
        });

    }

}
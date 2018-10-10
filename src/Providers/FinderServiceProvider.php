<?php


namespace Finder\Providers;


use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;


/**
 * Class FinderServiceProvider
 *
 * @author  raschi
 * @package Finder\Providers
 */
class FinderServiceProvider extends ServiceProvider
{

    /**
     * Template priority
     */
    CONST ORDER_NOW_PRIORITY = 0;


    /**
     *
     */
    public function register()
    {

        $this->getApplication()->register(FinderRouteServiceProvider::class);

    }


    /**
     * @param \Plenty\Plugin\Events\Dispatcher $dispatcher
     * @param \Plenty\Plugin\Templates\Twig    $twig
     */
    public function boot( Dispatcher $dispatcher, Twig $twig )
    {

    }


}
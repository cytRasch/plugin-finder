<?php


namespace Finder\Providers;


use IO\Helper\ResourceContainer;
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
     * Register method
     */
    public function register()
    {

        $this->getApplication()->register(FinderRouteServiceProvider::class);
    }


    /**
     * Boot method
     *
     * @param \Plenty\Plugin\Events\Dispatcher $dispatcher
     * @param \Plenty\Plugin\Templates\Twig    $twig
     */
    public function boot( Dispatcher $dispatcher, Twig $twig )
    {

        $dispatcher->listen('IO.Resource.Import', function ( ResourceContainer $resourceContainer )
        {
            $resourceContainer->addScriptTemplate('OrderNow::content.FinderJS');

        }, 0);
    }

}
<?php


namespace Finder\Providers;


use Plenty\Plugin\ServiceProvider;


/**
 * Class FinderServiceProvider
 *
 * @author  raschi
 * @package Finder\Providers
 */
class FinderServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function register()
    {

        $this->getApplication()->register(FinderRouteServiceProvider::class);
    }


}
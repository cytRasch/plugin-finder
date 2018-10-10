<?php


namespace Finder\Providers;


use Plenty\Plugin\ServiceProvider;


class FinderServiceProvider extends ServiceProvider
{
    /**
     * Template priority
     */
    CONST ORDER_NOW_PRIORITY = 0;

    public function register() {

        $this->getApplication()->register(FinderRouteServiceProvider::class);

    }


}
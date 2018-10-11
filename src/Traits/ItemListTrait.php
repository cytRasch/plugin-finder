<?php


namespace Finder\Traits;


use IO\Services\ItemSearch\Services\ItemSearchService;


/**
 * Trait ItemListTrait
 *
 * @package Finder\Traits
 */
trait ItemListTrait
{

    /**
     * @var
     */
    public $itemCountTotal;

    /**
     * @var
     */
    public $facets;


    /**
     * @param $defaultSearchFactories
     * @param $options
     * @return mixed
     */
    public function getItemCount( $defaultSearchFactories, $options )
    {

        /** @var ItemSearchService $itemSearchService */
        $itemSearchService = pluginApp(ItemSearchService::class);

        $searchResults = $itemSearchService->getResults($defaultSearchFactories);

        return $searchResults['itemList']['total'];
    }

}
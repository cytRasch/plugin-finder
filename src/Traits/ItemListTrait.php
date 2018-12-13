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
     * @return mixed
     */
    public function getItemCount( $defaultSearchFactories )
    {

        /** @var ItemSearchService $itemSearchService */
        $itemSearchService = pluginApp(ItemSearchService::class);

        $searchResults = $itemSearchService->getResults($defaultSearchFactories);

        return $searchResults['itemList']['total'];
    }


    /**
     * @param $defaultSearchFactories
     * @return mixed
     */
    public function getAllFacets( $defaultSearchFactories )
    {

        /** @var ItemSearchService $itemSearchService */
        $itemSearchService = pluginApp(ItemSearchService::class);

        $searchResults = $itemSearchService->getResults($defaultSearchFactories);

        return $searchResults['facets'];

    }

}
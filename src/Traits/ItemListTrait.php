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
     * @param       $defaultSearchFactories
     * @param       $options
     */
    protected function initItemList( $defaultSearchFactories, $options ) : void
    {

        /** @var ItemSearchService $itemSearchService */
        $itemSearchService = pluginApp(ItemSearchService::class);

        $searchResults = $itemSearchService->getResults($defaultSearchFactories);
        $this->itemCountTotal = $searchResults['itemList']['total'];
    }

}
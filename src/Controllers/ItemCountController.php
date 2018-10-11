<?php


namespace Finder\Controllers;


use Finder\Traits\ItemListTrait;
use IO\Services\ItemSearch\SearchPresets\CategoryItems;
use IO\Services\ItemSearch\SearchPresets\Facets;
use Plenty\Plugin\Http\Request;


/**
 * Class ItemCountController
 *
 * @author  raschi
 * @package Finder\Controllers
 */
class ItemCountController
{

    use ItemListTrait;


    /**
     * @param \Plenty\Plugin\Http\Request $request
     * @return mixed
     */
    public function index( Request $request )
    {

        $itemListOptions = [
            'facets'     => $request->facets,
            'categoryId' => $request->categoryId,
        ];

        $this->initItemList(
            [
                'itemList' => CategoryItems::getSearchFactory($itemListOptions),
                'facets'   => Facets::getSearchFactory($itemListOptions)
            ],
            $itemListOptions
        );

        return $this->itemCountTotal;
    }
}
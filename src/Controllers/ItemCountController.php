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
            'page'         => 1,
            'itemsPerPage' => 24,
            'sorting'      => 'texts.name1_asc',
            'facets'       => $request->get('facets'),
            'categoryId'   => $request->get('categoryId'),
            'priceMin'     => 0,
            'priceMax'     => 0
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
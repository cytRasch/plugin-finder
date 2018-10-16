<?php


namespace Finder\Controllers;


use Finder\Traits\ItemListTrait;
use IO\Services\ItemSearch\SearchPresets\CategoryItems;
use IO\Services\ItemSearch\SearchPresets\Facets;
use IO\Services\ItemSearch\SearchPresets\SearchItems;
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
     * @return array
     */
    public function index( Request $request ) : array
    {

        if ( $request->has('categoryId') ) {
            $itemListOptions = [
                'page'         => 1,
                'itemsPerPage' => 24,
                'sorting'      => 'texts.name1_asc',
                'facets'       => $request->get('facets'),
                'categoryId'   => $request->get('categoryId'),
                'priceMin'     => 0,
                'priceMax'     => 0
            ];

            $items = $this->getItemCount(
                [
                    'itemList' => CategoryItems::getSearchFactory($itemListOptions),
                    'facets'   => Facets::getSearchFactory($itemListOptions)
                ]
            );
        } else {

            $itemListOptions = [
                'page'         => 1,
                'itemsPerPage' => 24,
                'sorting'      => 'texts.name1_asc',
                'facets'       => $request->get('facets'),
                'query'        => '',
                'priceMin'     => 0,
                'priceMax'     => 0
            ];

            $items = $this->getItemCount(
                [
                    'itemList' => SearchItems::getSearchFactory($itemListOptions),
                    'facets'   => Facets::getSearchFactory($itemListOptions)
                ]
            );

        }

        return [
            'count' => $items
        ];
    }
}
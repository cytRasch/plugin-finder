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
     * @var array
     */
    public $itemListOptions = [
        'page'         => 1,
        'itemsPerPage' => 24,
        'sorting'      => 'texts.name1_asc',
        'priceMin'     => 0,
        'priceMax'     => 0
    ];


    /**
     * @param \Plenty\Plugin\Http\Request $request
     * @return array
     */
    public function index( Request $request ) : array
    {

        $this->itemListOptions['facets'] = $request->get('facets');

        if ( $request->has('categoryId') ) {

            $this->itemListOptions['categoryId'] = $request->get('categoryId');

            $searchFactory = [
                'itemList' => CategoryItems::getSearchFactory($this->itemListOptions),
                'facets'   => Facets::getSearchFactory($this->itemListOptions),
            ];

        } else {

            $this->itemListOptions['query'] = '';

            $searchFactory = [
                'itemList' => SearchItems::getSearchFactory($this->itemListOptions),
                'facets'   => Facets::getSearchFactory($this->itemListOptions),
            ];

        }

        $items = $this->getItemCount($searchFactory);

        return [
            'count' => $items
        ];
    }
}
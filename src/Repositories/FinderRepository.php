<?php


namespace Finder\Repositories;


use Finder\Traits\ItemListTrait;
use IO\Services\CategoryService;
use IO\Services\ItemSearch\SearchPresets\CategoryItems;
use IO\Services\ItemSearch\SearchPresets\Facets;
use IO\Services\ItemSearch\SearchPresets\SearchItems;
use IO\Services\SessionStorageService;
use Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\Item\Property\Contracts\PropertyGroupNameRepositoryContract;
use Plenty\Plugin\CachingRepository;
use Plenty\Plugin\ConfigRepository;


/**
 * Class FinderRepository
 *
 * @author  raschi
 * @package Finder\Repositories
 */
class FinderRepository implements FinderRepositoryInterface
{

    use ItemListTrait;

    /**
     * @var \Plenty\Plugin\CachingRepository
     */
    public $cache;

    /**
     * @var \Plenty\Plugin\ConfigRepository
     */
    public $config;

    /**
     * @var string
     */
    public $lang;

    /**
     * @var array
     */
    public $itemListOptions = [
        'page'         => 1,
        'itemsPerPage' => 24,
        'sorting'      => 'texts.name1_asc',
        'priceMin'     => 0,
        'priceMax'     => 0,
        'facets'       => ''
    ];


    /**
     * FinderRepository constructor.
     *
     * @param \Plenty\Plugin\CachingRepository $cachingRepository
     * @param \Plenty\Plugin\ConfigRepository  $configRepository
     */
    public function __construct( CachingRepository $cachingRepository, ConfigRepository $configRepository )
    {

        $this->cache = $cachingRepository;
        $this->config = $configRepository;

        $sessionStorageService = pluginApp(SessionStorageService::class);
        $this->lang = $sessionStorageService->getLang();
    }


    /**
     * @param array $categoriesAndProperties
     * @return array|mixed|null
     */
    public function getCategories( array $categoriesAndProperties )
    {

        $categories = null;



            try {

                $categoryService = pluginApp(CategoryService::class);
                $categories = [];

                foreach ( $categoriesAndProperties as $array ) {

                    $category = $categoryService->get($array['category']);

                    $categories[] = [
                        'id'   => $array['category'],
                        'name' => $category->details[0]->name,
                        'slug' => $category->details[0]->nameUrl,
                    ];
                }

                //$this->cache->put('finder-categories', $categories, $this->config->get('Finder.finder.caching_time'));

            } catch ( \Exception $exception ) {

                // die($exception);
            }


        return $categories;
    }


    /**
     * @param null  $categoryId
     * @param array $filter
     * @param bool  $alphabetically
     * @return array
     */
    public function getFacets( $categoryId = null, array $filter = [] , $alphabetically = false) : array
    {

        // empty array
        $properties = [];

        if ( $categoryId ) {

            $this->itemListOptions['categoryId'] = $categoryId;

            $searchFactory = [
                'itemList' => CategoryItems::getSearchFactory($this->itemListOptions),
                'facets'   => Facets::getSearchFactory($this->itemListOptions)
            ];

        } else {

            $this->itemListOptions['query'] = '';

            $searchFactory = [
                'itemList' => SearchItems::getSearchFactory($this->itemListOptions),
                'facets'   => Facets::getSearchFactory($this->itemListOptions)
            ];

        }

        $items = $this->getAllFacets($searchFactory);

        $facets = array_values(array_filter($items, function ( $value, $key ) use ( $filter )
        {

            return in_array($value['id'], $filter, false);

        }, ARRAY_FILTER_USE_BOTH));

        // mirror properties array structure
        // for better handling in VueJs
        foreach ( $facets as $key => $facet ) {

            $properties[$key]['propertyGroupId'] = $facet['id'];
            $properties[$key]['categoryId'] = $categoryId;
            $properties[$key]['lang'] = $this->lang;
            $properties[$key]['name'] = $facet['name'];

            foreach ( $facet['values'] as $k => $value ) {

                $properties[$key]['properties'][$k]['id'] = $value['id'];
                $properties[$key]['properties'][$k]['names'][0]['name'] = $value['name'];
                $properties[$key]['properties'][$k]['names'][1]['name'] = $value['name'];

            }

            // order items alphabetically
            if($alphabetically) {

                $lang = $this->lang === 'de' ? 0 : 1;

                usort($properties[$key]['properties'], function ( $a, $b ) use ($lang)
                {

                    return strcmp($a['names'][$lang]['name'], $b['names'][$lang]['name']);
                });
            }

        }

        return $properties;
    }


    /**
     * @param array                    $propertyGroupIds
     * @param \Finder\Repositories\int $categoryId
     * @param bool                     $alphabetically
     * @return array|mixed
     */
    public function getProperties( array $propertyGroupIds, int $categoryId, $alphabetically = false )
    {

        $content = [];
        $propertyGroupNameRepo = pluginApp(PropertyGroupNameRepositoryContract::class);
        $authHelper = pluginApp(AuthHelper::class);

        foreach ( $propertyGroupIds as $key => $id ) {

            $this->cache->forget('finder-property-' . $id);

            if ( $this->cache->has('finder-property-' . $id) ) {

                $content[] = $this->cache->get('finder-property-' . $id);
                continue;
            }

            $content[] = $authHelper->processUnguarded(function () use ( $propertyGroupNameRepo, $id )
            {

                $response = $propertyGroupNameRepo->findOne($id, $this->lang);

                $this->cache->put('finder-property-' . $id, $response, $this->config->get('Finder.finder.caching_time'));

                return $response;
            });

            $content[$key]['categoryId'] = $categoryId;

        }

        return $content;

    }
}

<?php

namespace Finder\Controllers;


use Finder\Traits\StringMatchTrait;
use IO\Services\CategoryService;
use IO\Services\SessionStorageService;
use Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\Item\Property\Contracts\PropertyGroupNameRepositoryContract;
use Plenty\Modules\Item\Property\Contracts\PropertyRepositoryContract;
use Plenty\Plugin\CachingRepository;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;


/**
 * Class FinderController
 *
 * @author  raschi
 * @package Finder\Controllers
 */
class FinderController extends Controller
{

    use StringMatchTrait;

    /**
     * @var \Plenty\Plugin\ConfigRepository
     */
    protected $config;

    /**
     * @var \Plenty\Plugin\CachingRepository
     */
    protected $cache;

    /**
     * @var string
     */
    protected $lang = 'de';

    /**
     * @var array
     */
    private $arrayOfCategoriesAndProperties;


    /**
     * @var array
     */
    public $properties = [];


    /**
     * FinderController constructor.
     *
     * @param \Plenty\Plugin\ConfigRepository  $configRepository
     * @param \Plenty\Plugin\CachingRepository $cachingRepository
     */
    public function __construct( ConfigRepository $configRepository, CachingRepository $cachingRepository )
    {

        $this->config = $configRepository;
        $this->cache = $cachingRepository;

        $this->cache->forget('finder-categories');

        /** @var SessionStorageService $sessionStorageService */
        $sessionStorageService = pluginApp(SessionStorageService::class);
        $this->lang = $sessionStorageService->getLang();

        $this->arrayOfCategoriesAndProperties = $this->getCleanObjectFromString($this->config->get('Finder.finder.category_ids'));

    }


    /**
     * @return array
     */
    public function index() : array
    {

        $categories = $this->arrayOfCategoriesAndProperties[0]['category'] === 0 ? [] : $this->getCategories();

        foreach ( $this->arrayOfCategoriesAndProperties as $array ) {

            foreach ( $array['properties'] as $property ) {

                $props = $this->getProperties($property, $array['category']);
                $props->categoryId =  $array['category'];
                $this->properties[] = $props;

            }

        }

        return [
            'lang'           => $this->lang,
            'categories'     => $categories,
            'propertyGroups' => $this->properties,
            'selectFields'   => count($this->arrayOfCategoriesAndProperties[0]['properties']),
            'showItemCount'  => (bool) $this->config->get('Finder.finder.show_items'),
        ];
    }


    /**
     * @param $propertyGroupId
     * @return mixed
     */
    public function show( $propertyGroupId )
    {

        $properties = pluginApp(PropertyRepositoryContract::class);
        $authHelper = pluginApp(AuthHelper::class);

        return $authHelper->processUnguarded(
            function () use ( $properties, $propertyGroupId )
            {

                return $properties->search(
                    ['*'],
                    100,
                    1,
                    ['names'],
                    ['groupId' => $propertyGroupId]
                );
            }
        );
    }


    /**
     * @return mixed
     *
     */
    public function getCategories()
    {

        $categories = null;

        if ( $this->cache->has('finder-categories') ) {

            $categories = $this->cache->get('finder-categories');

        } else {

            try {

                $categoryService = pluginApp(CategoryService::class);
                $categories = [];

                foreach ( $this->arrayOfCategoriesAndProperties as $array ) {

                    $category = $categoryService->get($array['category']);

                    $categories[] = [
                        'id'   => $array['category'],
                        'name' => $category->details[0]->name,
                        'slug' => $category->details[0]->canonicalLink,
                    ];
                }

                $this->cache->put('finder-categories', $categories, $this->config->get('Finder.finder.caching_time'));

            } catch ( \Exception $exception ) {

                //
            }
        }


        return $categories;
    }


    /**
     * @param $id
     * @param $category
     * @return mixed
     */
    public function getProperties( $id, $category )
    {

        if ( $this->cache->has('finder-property-' . $id) ) {

            return $this->cache->get('finder-property-' . $id);
        }


        $propertyGroups = pluginApp(PropertyGroupNameRepositoryContract::class);
        $authHelper = pluginApp(AuthHelper::class);

        return $authHelper->processUnguarded(
            function () use ( $propertyGroups, $id, $category )
            {

                $response = $propertyGroups->findOne($id, $this->lang);
                //$response->categoryId = $category;

                $this->cache->put('finder-property-' . $id, $response, $this->config->get('Finder.finder.caching_time'));

                return $response;

            }
        );
    }


}
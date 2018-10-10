<?php

namespace Finder\Controllers;


use IO\Services\CategoryService;
use IO\Services\ItemService;
use Plenty\Modules\Property\Contracts\PropertyGroupRepositoryContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;


/**
 * Class FinderController
 *
 * @author  raschi
 * @package Finder\Controllers
 */
class FinderController extends Controller
{


    /**
     * @var \Plenty\Plugin\ConfigRepository
     */
    protected $config;

    /**
     * @var array
     */
    private $categories;

    /**
     * @var array
     */
    private $propertyGroups;

    /**
     * @var \Plenty\Modules\Property\Contracts\PropertyGroupRepositoryContract
     */
    public $test;


    /**
     * FinderController constructor.
     *
     * @param \Plenty\Plugin\ConfigRepository                                    $configRepository
     * @param \Plenty\Modules\Property\Contracts\PropertyGroupRepositoryContract $propertyGroupRepositoryContract
     */
    public function __construct( ConfigRepository $configRepository, PropertyGroupRepositoryContract $propertyGroupRepositoryContract )
    {

        $this->config = $configRepository;

        $values = explode(';', $this->config->get('Finder.finder.category_ids'));

        $this->categories = $values[0];
        $this->propertyGroups = explode(',', $values[1]);

        $this->test = $propertyGroupRepositoryContract;

    }


    /**
     * @param \Plenty\Plugin\Http\Request $request
     * @return array
     */
    public function index( Request $request ) : array
    {

        /** @var CategoryService $categoryService */
        $categoryService = pluginApp(CategoryService::class);
        $itemService = pluginApp(ItemService::class);

        $categories = [];

        foreach ( $this->categories as $category ) {

            $c = $categoryService->get($category);
            $i = $itemService->getItemForCategory($category, [], 1);

            $categories[] = [
                'id'    => $category,
                'name'  => $c->details[0]->name,
                'items' => $i->total,
                'test'  => $this->test->getGroup(3),
            ];
        }

        return $categories;
    }


    /**
     * @param $category
     * @param $group
     * @return mixed
     */
    public function show( $category, $group )
    {

        return $this->categories;

    }

}
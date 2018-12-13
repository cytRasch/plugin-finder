<?php

namespace Finder\Controllers;


use Finder\Repositories\FinderRepository;
use Finder\Traits\ItemListTrait;
use Finder\Traits\StringMatchTrait;
use Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\Item\Property\Contracts\PropertyRepositoryContract;
use Plenty\Plugin\Controller;


/**
 * Class FinderController
 *
 * @author  raschi
 * @package Finder\Controllers
 */
class FinderController extends Controller
{

    use StringMatchTrait, ItemListTrait;

    /**
     * @var \Finder\Repositories\FinderRepository
     */
    public $finder;

    /**
     * @var bool
     */
    public $showItemCount;

    /**
     * @var array
     */
    public $categoriesAndProperties;

    /**
     * @var array
     */
    public $properties = [];

    /**
     * @var string
     */
    protected $useProperties;

    /*
     * @var bool
     */
    protected $alphabetically;


    /**
     * FinderController constructor.
     *
     * @param \Finder\Repositories\FinderRepository $finderRepository
     */
    public function __construct( FinderRepository $finderRepository )
    {

        $this->finder = $finderRepository;

        // get configuration values
        $this->useProperties = $this->getBooleanValue($this->finder->config->get('Finder.finder.logic_properties'));
        $this->showItemCount = $this->getBooleanValue($this->finder->config->get('Finder.finder.show_items'));
        $this->alphabetically = $this->getBooleanValue($this->finder->config->get('Finder.finder.order_alphabetically'));

        $this->categoriesAndProperties = $this->getCleanObjectFromString($this->finder->config->get('Finder.finder.category_ids'));

    }


    /**
     * @return array
     */
    public function index() : array
    {

        $content = $this->categoriesAndProperties;
        $categories = $content[0]['category'] === 0 ? [] : $this->finder->getCategories($content);

        foreach ( $content as $array ) {

            if ( $this->useProperties ) {

                $this->properties = $this->finder->getProperties($array['properties'], $array['category']);

            } else {

                $this->properties = $this->finder->getFacets($array['category'], $array['properties'], $this->alphabetically);
            }
        }

        return [
            'test'           => $content,
            'lang'           => $this->finder->lang,
            'categories'     => $categories,
            'propertyGroups' => $this->properties,
            'selectFields'   => count($content[0]['properties']),
            'showItemCount'  => $this->showItemCount,
            'useProperties'  => $this->useProperties,
            'alphabetically' => $this->alphabetically,
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

}
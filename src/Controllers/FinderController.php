<?php

namespace Finder\Controllers;


use IO\Services\CategoryService;
use Plenty\Modules\Category\Models\Category;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\Loggable;


/**
 * Class FinderController
 *
 * @author  raschi
 * @package Finder\Controllers
 */
class FinderController extends Controller
{

    use Loggable;

    /**
     * @var \Plenty\Plugin\ConfigRepository
     */
    protected $config;

    /**
     * @var array
     */
    private $categories;

    protected $lang;


    /**
     * FinderController constructor.
     *
     * @param \Plenty\Plugin\ConfigRepository $configRepository
     */
    public function __construct( ConfigRepository $configRepository )
    {

        $this->config = $configRepository;

        $this->categories = explode(',', $this->config->get('Finder.finder.category_ids'));
    }


    /**
     * @param \Plenty\Plugin\Http\Request $request
     * @return array
     */
    public function index( Request $request ) : array
    {
        /** @var CategoryService $categoryService */
        $categoryService = pluginApp(CategoryService::class);

        $categories = [];

        foreach ( $this->categories as $category ) {

            $c = $categoryService->get($category);
            $categories[] = [
                'id'   => $category,
                'name' => $c->details[0]->name
            ];
        }

        $this->getLogger('FinderController_index')
            ->info('Call rest route successful');

        return $categories;
    }


    /**
     * @param $category
     * @param $group
     * @return mixed
     */
    public function show( $category, $group )
    {

        return $category;

    }

}
<?php

namespace Finder\Controllers;


use IO\Services\CategoryService;
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

    protected $lang;

    /**
     * FinderController constructor.
     *
     * @param \Plenty\Plugin\ConfigRepository $configRepository
     */
    public function __construct( ConfigRepository $configRepository )
    {
        $this->config = $configRepository;
    }


    /**
     * @param \Plenty\Plugin\Http\Request $request
     * @return array
     */
    public function index( Request $request ) : array
    {

        $categoryService = pluginApp(CategoryService::class);

        $this->getLogger('FinderController_index')
            ->info('Call rest route successful');

        return $categoryService->get(561);
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
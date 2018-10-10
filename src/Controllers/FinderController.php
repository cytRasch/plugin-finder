<?php

namespace Finder\Controllers;


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

        $this->getLogger('FinderController_index')
            ->info('Call rest route successful');

        return [
            'test' => 'test'
        ];
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
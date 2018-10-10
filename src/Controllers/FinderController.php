<?php

namespace Finder\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;


/**
 * Class FinderController
 *
 * @author  raschi
 * @package Finder\Controllers
 */
class FinderController extends Controller {

    public function index(Request $request) {

        return $request->all();
    }

    public function show($category, $group) {

        return $category;

    }

}
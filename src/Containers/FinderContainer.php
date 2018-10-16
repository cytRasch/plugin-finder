<?php

namespace Finder\Containers;


use Finder\Controllers\FinderController;
use Plenty\Plugin\Templates\Twig;


/**
 * Class FinderContainer
 *
 * @author  raschi
 * @package Finder\Containers
 */
class FinderContainer
{

    /**
     * @param \Plenty\Plugin\Templates\Twig $twig
     * @return string
     */
    public function call( Twig $twig )
    {
        return $twig->render('Finder::content.Finder');
    }

}
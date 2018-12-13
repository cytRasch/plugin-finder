<?php

namespace Finder\Containers;


use Plenty\Plugin\Templates\Twig;


/**
 * Class OrderNowJS
 *
 * @package OrderNow\Containers
 */
class FinderJS
{

    /**
     * @param \Plenty\Plugin\Templates\Twig $twig
     * @return string
     */
    public function call( Twig $twig ) : string
    {
        return $twig->render('Finder::content.FinderJS');
    }
}
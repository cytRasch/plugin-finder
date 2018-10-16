<?php

namespace Finder\Containers;

use Plenty\Plugin\Templates\Twig;

/**
 * Class OrderNowCSS
 *
 * @package OrderNow\Containers
 */
class FinderCSS
{

    /**
     * @param \Plenty\Plugin\Templates\Twig $twig
     * @return string
     */
    public function call( Twig $twig ) : string
    {
        return $twig->render('Finder::content.FinderCSS');
    }
}
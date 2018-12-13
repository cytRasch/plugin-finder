<?php


namespace Finder\Traits;

/**
 * Class FlattenArrayTrait
 *
 * @author  raschi
 * @package Finder\Traits
 */
trait FlattenArrayTrait
{

    /**
     * @param array $array
     * @return array
     */
    public function flatten( array $array ) : array
    {

        $return = array();
        array_walk_recursive($array, function ( $a ) use ( &$return )
        {

            $return[] = $a;
        });

        return $return;
    }
}
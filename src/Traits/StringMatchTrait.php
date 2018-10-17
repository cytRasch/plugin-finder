<?php


namespace Finder\Traits;


/**
 * Trait StringMatchTrait
 *
 * @package Finder\Traits
 */
trait StringMatchTrait
{


    /**
     * @param $string
     * @return array
     */
    public function getCleanObjectFromString( $string ) : array
    {

        $array = explode('|', $string);

        $response = [];

        foreach ( $array as $key => $value ) {

            $a = explode(';', $value);

            $response[] = [
                'category'   => (int) $a[0],
                'properties' => array_map('intval', explode(',', $a[1])),
            ];
        }

        return $response;
    }


    /**
     * @param      $value
     * @param bool $default
     * @return bool
     */
    protected function getBooleanValue( $value, $default = false ) : bool
    {

        if ( $value === "true" || $value === "false" ) {
            return $value === "true";
        }

        return $default;
    }


}
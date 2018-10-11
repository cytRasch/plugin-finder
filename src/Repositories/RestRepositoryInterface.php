<?php


namespace Finder\Repositories;

/**
 * Interface RestRepositoryInterface
 *
 * @package Finder\Repositories
 */
interface RestRepositoryInterface
{

    /**
     * @return mixed
     */
    public function client();


    /**
     * @param        $groupId
     * @param string $lang
     * @return array
     */
    public function getPropertyNames( $groupId, $lang = 'de' ) : array;


    /**
     * @param      $groupId
     * @param bool $names
     * @param int  $page
     * @return array
     */
    public function getPropertiesByGroupId( $groupId, $names = true, $page = 1 ) : array;

}
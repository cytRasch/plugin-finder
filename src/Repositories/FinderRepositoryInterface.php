<?php


namespace Finder\Repositories;

/**
 * Interface FinderRepositoryInterface
 *
 * @package Finder\Repositories
 */
interface FinderRepositoryInterface
{

    /**
     * @param array $categoriesAndProperties
     * @return mixed
     */
    public function getCategories( array $categoriesAndProperties );


    /**
     * @param null  $categoryId
     * @param array $filter
     * @return array
     */
    public function getFacets( $categoryId = null, array $filter = [] ) : array;


    /**
     * @param array $propertyGroupIds
     * @param int   $categoryId
     * @return mixed
     */
    public function getProperties( array $propertyGroupIds, int $categoryId);
}
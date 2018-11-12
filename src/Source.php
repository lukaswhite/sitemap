<?php

namespace Lukaswhite\Sitemap;

/**
 * Interface Source
 *
 * This contract (interface) defines a source of data for the sitemap.
 *
 * @package Lukaswhite\Sitemap
 */
interface Source
{
    /**
     * Get the pages
     * @return array
     */
    public function getPages( );
}
<?php

namespace Lukaswhite\Sitemap;

/**
 * Class Simple
 *
 * A really simple data source for the sitemaps. It's essentially just an array
 * of pages.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Simple implements Source
{
    /**
     * The pages
     *
     * @var array
     */
    protected $pages;

    /**
     * Simple constructor.
     *
     * @param array $pages
     */
    public function __construct( $pages = [ ] )
    {
        $this->pages = $pages;
    }

    /**
     * Add a page
     *
     * @param Page $page
     * @return $this
     */
    public function addPage( Page $page )
    {
        $this->pages[ ] = $page;
        return $this;
    }

    /**
     * Get the pages
     *
     * @return array
     */
    public function getPages( )
    {
        return $this->pages;
    }
}
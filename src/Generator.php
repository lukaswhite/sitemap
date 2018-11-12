<?php

namespace Lukaswhite\XmlSitemaps;

use Thepixeldeveloper\Sitemap\Urlset;
use Thepixeldeveloper\Sitemap\Url;
use Thepixeldeveloper\Sitemap\Drivers\XmlWriterDriver;

/**
 * Class Generator
 *
 * This class provides the ability to generate sitemaps (e.g. XML).
 *
 * It allows modules and components to "hook" into it, and provide pages for inclusion.
 *
 * The idea is:
 *
 *  - an instance is created (a singleton)
 *  - any part of the application that has pages to include grabs that instance
 *  - it then calls addSource(), providing a class that implements the Source contract
 *
 * Then, when a sitemap is being generated, it simply combines the pages from all of its sources.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Generator
{
    /**
     * The data sources
     *
     * @var array
     */
    protected $sources = [ ];

    /**
     * The pages
     *
     * @var array
     */
    protected $pages = [ ];

    /**
     * Add a data source
     *
     * @param Source $source
     * @return $this
     */
    public function addSource( Source $source )
    {
        $this->sources[ ] = $source;
        return $this;
    }

    /**
     * Get the sitemap data
     *
     * @return array
     */
    public function getData( )
    {
        $this->pages = [ ];

        if ( count( $this->sources ) ) {
            foreach( $this->sources as $source ) {
                $this->pages = array_merge( $this->pages, $source->getPages( ) );
            }
        }
        return $this->pages;
    }

    /**
     * Get the sitemap, as XML.
     *
     * @return string
     */
    public function getXml( )
    {
        $urlset = new Urlset();

        $pages = $this->getData( );

        foreach( $pages as $page ) {
            $url = new Url( $page->getUrl( ) );
            $url->setLastMod( $page->getLastModified( ) );
            if ( $page->getChangeFreq( ) ) {
                $url->setChangeFreq( $page->getChangeFreq( ) );
            }
            $url->setPriority( $page->getPriority( ) );

            $urlset->add($url);

        }

        $driver = new XmlWriterDriver();

        $urlset->accept( $driver );

        return  $driver->output( );
    }
}
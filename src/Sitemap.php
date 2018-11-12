<?php

namespace Lukaswhite\Sitemap;

/**
 * Class Sitemap
 *
 * Represents a sitemap.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Sitemap implements \JsonSerializable
{
    /**
     * The pages that make up this sitemap.
     *
     * @var array
     */
    protected $pages;

    /**
     * The last modified date
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * The location (URL) of the sitemap
     *
     * @var string
     */
    protected $location;

    /**
     * Sitemap constructor.
     */
    public function __construct( array $pages = [ ] )
    {
        $this->pages = $pages;
    }

    /**
     * Add a page to the sitemap
     *
     * @param Page $page
     * @return self
     */
    public function addPage( Page $page ) : self
    {
        $this->pages[ ] = $page;
        return $this;
    }

    /**
     * Add multiple pages to this sitemap
     *
     * @param array $pages
     * @return self
     */
    public function addPages( array $pages ) : self
    {
        foreach( $pages as $page )
        {
            /** @var Page $page */
            $this->addPage( $page );
        }
        return $this;
    }

    /**
     * Get the pages that make up this sitemap
     *
     * @return array
     */
    public function getPages( ) : array
    {
        return $this->pages;
    }

    /**
     * Get the last modified date/time of the sitemap
     *
     * @return \DateTime
     */
    public function getLastModified( ) : ?\DateTime
    {
        return $this->lastModified ? $this->lastModified : new \DateTime( );
    }

    /**
     * Set the last modified date/time of the sitemap
     *
     * @param \DateTime $lastModified
     * @return $this
     */
    public function setLastModified( \DateTime $lastModified ) : self
    {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * Get the location (URL) of the sitemap
     *
     * @return string
     */
    public function getLocation( ) : string
    {
        return $this->location;
    }

    /**
     * Set the location (URL) of the sitemap
     *
     * @param string $location
     * @return $this
     */
    public function setLocation( string $location ) : self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Sort the pages that make up this sitemap, highest priority first.
     *
     * @return self
     */
    public function sortByPriority( )
    {
        usort( $this->pages, function( $a, $b ) {
            /** @var Page $a */
            $a = $a->getPriority( );
            /** @var Page $b */
            $b = $b->getPriority( );
            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        } );
    }

    /**
     * Sort the pages that make up this sitemap by title
     *
     * @return self
     */
    public function sortByTitle( )
    {
        usort( $this->pages, function( $a, $b ) {
            /** @var Page $a */
            /** @var Page $b */
            return strcmp( $a->getTitle( ), $b->getTitle( ) );
        } );
    }

    /**
     * Create an array representation of this sitemap
     *
     * @return array
     */
    public function toArray( ) : array
    {
        return array_map(
            function( Page $page ) {
                return $page->toArray( );
            },
            $this->getPages( )
        );
    }

    /**
     * Defines the data that's used to create a JSON representation of this sitemap. It's
     * useful for, for example, returning an API representation for the backend of an app.
     *
     * @return array
     */
    public function jsonSerialize( )
    {
        return $this->toArray( );
    }
}
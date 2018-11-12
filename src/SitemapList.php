<?php

namespace Lukaswhite\Sitemap;

use Lukaswhite\Sitemap\Writer\AbstractWriter;

/**
 * Class SitemapList
 *
 * Represents a sitemap list. This allows you to break up a sitemap into separate
 * files.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class SitemapList extends AbstractWriter
{
    /**
     * The sitemaps
     *
     * @var array
     */
    protected $sitemaps;

    /**
     * Simple constructor.
     *
     * @param array $sitemaps
     */
    public function __construct( $sitemaps = [ ] )
    {
        $this->sitemaps = $sitemaps;
    }

    /**
     * Add a sitemap
     *
     * @param Sitemap $sitemap
     * @return self
     */
    public function addSitemap( Sitemap $sitemap ) : self
    {
        $this->sitemaps[ ] = $sitemap;
        return $this;
    }

    /**
     * Get the sitemaps in this sitemap list
     *
     * @return array
     */
    public function getSitemaps( ) : array
    {
        return $this->sitemaps;
    }

    /**
     * Write the sitemap list
     *
     * @return string
     */
    public function write( ) : string
    {
        $doc = new \DOMDocument( '1.0', 'UTF-8' );

        $index = $doc->createElement( 'sitemapindex' );
        $index->setAttribute(
            'xmlns',
            'http://www.sitemaps.org/schemas/sitemap/0.9'
        );

        $doc->appendChild( $index );

        foreach( $this->sitemaps as $sitemap ) {
            /** @var Sitemap $sitemap */
            $el = $doc->createElement( 'sitemap' );
            $el->appendChild( $doc->createElement( 'loc', $sitemap->getLocation( ) ) );
            if ( $sitemap->getLastModified( ) ) {
                $el->appendChild(
                    $doc->createElement( 'lastmod',
                    $sitemap->getLastModified( )->format( 'Y-m-d' ) )
                );
            }
            $index->appendChild( $el );
        }

        return $doc->saveXML( );
    }

}
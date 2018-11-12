<?php

namespace Lukaswhite\Sitemap\Writer;

use Lukaswhite\Sitemap\Page;

/**
 * Class RSS
 *
 * This class is used to write a sitemap as an RSS feed.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class RSS extends AbstractWriter
{
    /**
     * The channel title
     *
     * @var string
     */
    protected $channelTitle = 'Sitemap';

    /**
     * The channel description
     *
     * @var string
     */
    protected $channelDescription = 'RSS Sitemap';

    /**
     * Write to a string
     *
     * @return string
     */
    public function write( ) : string
    {
        $doc = new \DOMDocument( '1.0', 'UTF-8' );

        $rss = $doc->createElement( 'rss' );
        $rss->setAttribute('version', '2.0');
        $rss->setAttribute( 'xmlns:content', 'http://purl.org/rss/1.0/modules/content/' );
        $rss->setAttribute( 'xmlns:atom', 'http://www.w3.org/2005/Atom' );

        $channel = $rss->appendChild( $doc->createElement( 'channel' ) );

        $channel->appendChild( $doc->createElement( 'link', $this->sitemap->getLocation( ) ) );

        $channel->appendChild( $doc->createElement( 'title', $this->channelTitle ) );
        $channel->appendChild( $doc->createElement('description', $this->channelDescription ) );

        if ( $this->sitemap->getLastModified( ) ) {
            $channel->appendChild( $doc->createElement(
                'lastBuildDate',
                $this->sitemap->getLastModified( )->format( DATE_RSS ) )
            );
        }

        $atomLink = $doc->createElement( 'atom:link');
        $atomLink->setAttribute( 'href', $this->sitemap->getLocation( ) );
        $atomLink->setAttribute( 'rel', 'self' );
        $atomLink->setAttribute( 'type', 'application/rss+xml' );

        $channel->appendChild( $atomLink );

        foreach( $this->sitemap->getPages( ) as $page ) {

            /** @var Page $page */

            $item = $doc->createElement( 'item' );

            $item->appendChild( $doc->createElement( 'link', $page->getUrl( ) ) );
            $item->appendChild( $doc->createElement( 'guid', $page->getUrl( ) ) );

            if ( $page->getTitle( ) ) {
                $item->appendChild( $doc->createElement( 'title', $page->getTitle( ) ) );
            }

            $atomLink = $doc->createElement( 'atom:link');
            $atomLink->setAttribute( 'href', $page->getUrl( ) );
            $atomLink->setAttribute( 'rel', 'self' );
            $atomLink->setAttribute( 'type', 'application/rss+xml' );

            $item->appendChild( $atomLink );

            $channel->appendChild( $item );

        }

        $doc->appendChild( $rss );

        return $doc->saveXML( );
    }

    /**
     * Set the channel title
     *
     * @param string $title
     * @return $this
     */
    public function setChannelTitle( string $title )
    {
        $this->channelTitle = $title;
        return $this;
    }

    /**
     * Set the channel description
     *
     * @param string $description
     * @return $this
     */
    public function setChannelDescription( string $description )
    {
        $this->channelDescription = $description;
        return $this;
    }
}
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
class Atom extends AbstractWriter
{
    /**
     * The feed ID
     *
     * @var string
     */
    protected $feedId;

    /**
     * The feed title
     *
     * @var string
     */
    protected $feedTitle = 'Sitemap';

    /**
     * The feed author
     *
     * @var string
     */
    protected $feedAuthor = [ 'name' => 'PHP Sitemap' ];

    /**
     * Write to a string
     *
     * @return string
     */
    public function write( ) : string
    {
        $doc = new \DOMDocument( '1.0', 'UTF-8' );

        $feed = $doc->createElement( 'feed' );
        $feed->setAttribute('xmlns', 'http://www.w3.org/2005/Atom');

        $linkToSelf = $doc->createElement( 'link' );
        $linkToSelf->setAttribute( 'href', $this->sitemap->getLocation( ) );
        $linkToSelf->setAttribute( 'rel', 'self' );

        $feed->appendChild( $linkToSelf );

        $feed->appendChild(
            $doc->createElement( 'updated', $this->sitemap->getLastModified( )->format( DATE_ATOM ) )
        );

        $feed->appendChild( $doc->createElement( 'title', $this->feedTitle ) );

        if ( $this->feedId ) {
            $feed->appendChild( $doc->createElement( 'id', $this->feedId ) );
        } else {
            $feed->appendChild( $doc->createElement( 'id', $this->sitemap->getLocation( ) ) );
        }


        $author = $feed->appendChild( $doc->createElement( 'author' ) );
        $author->appendChild( $doc->createElement( 'name', $this->feedAuthor[ 'name' ] ) );

        if ( isset( $this->feedAuthor[ 'email' ] ) ) {
            $author->appendChild( $doc->createElement( 'email', $this->feedAuthor[ 'email' ] ) );
        }

        foreach( $this->sitemap->getPages( ) as $page ) {

            /** @var Page $page */

            $entry = $doc->createElement( 'entry' );

            $link = $doc->createElement( 'link' );
            $link->setAttribute( 'href', $page->getUrl( ) );

            $entry->appendChild( $link );

            $entry->appendChild( $doc->createElement( 'id', $page->getId( ) ) );

            if ( $page->getTitle( ) ) {
                $entry->appendChild( $doc->createElement( 'title', $page->getTitle( ) ) );
            }

            $entry->appendChild(
                $doc->createElement( 'updated', $page->getLastModified( )->format( DATE_ATOM ) )
            );

            $feed->appendChild( $entry );

        }

        $doc->appendChild( $feed );

        return $doc->saveXML( );
    }

    /**
     * Set the feed ID
     *
     * @param string $id
     * @return $this
     */
    public function setFeedId( string $id )
    {
        $this->feedId = $id;
        return $this;
    }

    /**
     * Set the feed title
     *
     * @param string $title
     * @return $this
     */
    public function setFeedTitle( string $title )
    {
        $this->feedTitle = $title;
        return $this;
    }

    /**
     * Set the feed author
     *
     * @param string $name
     * @param string $email
     * @return $this
     */
    public function setFeedAuthor( string $name, ?string $email )
    {
        $this->feedAuthor[ 'name' ] = $name;
        if ( $email ) {
            $this->feedAuthor[ 'email' ] = $email;
        }
        return $this;
    }
}
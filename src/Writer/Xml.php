<?php

namespace Lukaswhite\Sitemap\Writer;

use Lukaswhite\Sitemap\AlternateLink;
use Lukaswhite\Sitemap\Extensions\Image;
use Lukaswhite\Sitemap\Extensions\Video;
use Lukaswhite\Sitemap\Page;

/**
 * Class Xml
 *
 * This class is used to write a sitemap to XML.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Xml extends AbstractWriter
{
    /**
     * Any processing instructions.
     *
     * @var array
     */
    protected $processingInstructions = [ ];

    /**
     * Any comments
     *
     * @var array
     */
    protected $comments = [ ];

    /**
     * Add a processing instruction
     *
     * @param string $name
     * @param string $value
     * @return self
     */
    public function addProcessingInstruction( $name, $value ) : self
    {
        $this->processingInstructions[ $name ] = $value;
        return $this;
    }

    /**
     * Link an XSL stylesheet to this sitemap
     *
     * @param string $url
     * @return $this
     */
    public function addXslStylesheet( $url ) : self
    {
        return $this->addProcessingInstruction(
            'xml-stylesheet',
            sprintf('type="text/xsl" href="%s"', $url )
        );
    }

    /**
     * Add a comment
     *
     * @param string $comment
     * @return $this
     */
    public function addComment( string $comment ) : self
    {
        $this->comments[ ] = $comment;
        return $this;
    }

    /**
     * Write to a string
     *
     * @return string
     */
    public function write( ) : string
    {
        $doc = new \DOMDocument( '1.0', 'UTF-8' );

        if ( count( $this->processingInstructions ) ) {
            foreach( $this->processingInstructions as $name => $value ) {
                $doc->appendChild(
                    $doc->createProcessingInstruction( $name, $value )
                );
            }
        }

        if ( count( $this->comments ) ) {
            foreach( $this->comments as $comment ) {
                $doc->appendChild(
                    $doc->createComment( $comment )
                );
            }
        }

        $urlset = $doc->createElement( 'urlset' );

        // Set the sitemap namespace
        $urlset->setAttribute(
            'xmlns',
            'http://www.sitemaps.org/schemas/sitemap/0.9'
        );
        $urlset->setAttribute(
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance'
        );
        $urlset->setAttribute(
            'xmlns:xhtml',
            'http://www.w3.org/1999/xhtml'
        );
        $urlset->setAttribute(
            'xmlns:image',
            'http://www.google.com/schemas/sitemap-image/1.1'
        );
        $urlset->setAttribute(
            'xmlns:video',
            'http://www.google.com/schemas/sitemap-video/1.1'
        );

        foreach( $this->sitemap->getPages( ) as $page ) {

            /** @var Page $page */

            $url = $doc->createElement( 'url' );

            $url->appendChild( $doc->createElement( 'loc', $page->getUrl( ) ) );
            $url->appendChild( $doc->createElement(
                    'lastmod',
                    $page->getLastModified( )->format( DATE_W3C )
                )
            );
            $url->appendChild( $doc->createElement( 'priority', round( $page->getPriority( ), 1 ) ) );

            if ( $page->getChangeFreq( ) ) {
                $url->appendChild( $doc->createElement( 'changefreq', $page->getChangeFreq( ) ) );
            }

            $this->addAlternateLinks( $doc, $url, $page );

            $this->addImages( $doc, $url, $page );

            $this->addVideos( $doc, $url, $page );

            $urlset->appendChild( $url );

        }

        $doc->appendChild( $urlset );

        return $doc->saveXML( );
    }

    /**
     * Add alternate links to a page
     *
     * @param \DomDocument $doc
     * @param \DOMElement $el
     * @param Page $page
     */
    protected function addAlternateLinks( \DomDocument $doc, \DOMElement $el, Page $page )
    {
        if ( count( $page->getAlternates( ) ) ) {
            foreach( $page->getAlternates( ) as $alternate ) {
                /** @var AlternateLink $alternate */
                $a = $doc->createElement('xthml:link' );
                $a->setAttribute( 'rel', 'alternate' );
                $a->setAttribute( 'href', $alternate->getUrl( ) );
                $a->setAttribute( 'hreflang', $alternate->getLanguage( ) );
                $el->appendChild( $a );
            }
        }
    }

    /**
     * Add images to a page
     *
     * @param \DomDocument $doc
     * @param \DOMElement $el
     * @param Page $page
     */
    protected function addImages( \DomDocument $doc, \DOMElement $el, Page $page )
    {
        if ( count( $page->getImages( ) ) ) {
            foreach( $page->getImages( ) as $image ) {
                /** @var Image $image */
                $i = $doc->createElement('image:image' );
                $i->appendChild( $doc->createElement( 'image:loc', $image->getLocation( ) ) );
                if ( $image->getCaption( ) ) {
                    $i->appendChild( $doc->createElement( 'image:caption', $image->getCaption( ) ) );
                }
                if ( $image->getTitle( ) ) {
                    $i->appendChild( $doc->createElement( 'image:title', $image->getTitle( ) ) );
                }
                if ( $image->getGeoLocation( ) ) {
                    $i->appendChild( $doc->createElement( 'image:geo_location', $image->getGeoLocation( ) ) );
                }
                if ( $image->getLicense( ) ) {
                    $i->appendChild( $doc->createElement( 'image:license', $image->getLicense() ) );
                }
                $el->appendChild( $i );
            }
        }
    }

    /**
     * Add videos to a page
     *
     * @param \DomDocument $doc
     * @param \DOMElement $el
     * @param Page $page
     */
    protected function addVideos( \DomDocument $doc, \DOMElement $el, Page $page )
    {
        if ( count( $page->getVideos( ) ) ) {
            foreach( $page->getVideos( ) as $video ) {
                /** @var Video $video */
                $v = $doc->createElement('video:video' );

                $v->appendChild( $doc->createElement( 'video:title', $video->getTitle() ) );
                $v->appendChild( $doc->createElement( 'video:description', $video->getDescription() ) );

                if ( $video->getContentLocation( ) ) {
                    $v->appendChild( $doc->createElement( 'video:content_loc', $video->getContentLocation() ) );
                } elseif ( $video->getThumbnailLocation( ) ) {
                    $v->appendChild(
                        $doc->createElement( 'video:thumbnail_loc', $video->getThumbnailLocation() )
                    );
                }

                if ( $video->getPlayer( ) ) {
                    $player = $doc->createElement( 'video:player_loc', $video->getPlayer( )->getLocation( ) );
                    if ( $video->getPlayer( )->getAllowEmed( ) ) {
                        $player->setAttribute(
                            'allow_embed',
                            $video->getPlayer( )->allowsEmbedding( ) ? 'yes' : 'no'
                        );
                    }
                    $v->appendChild( $player );
                }

                if ( $video->getDuration( ) ) {
                    $v->appendChild( $doc->createElement( 'video:duration', $video->getDuration( ) ) );
                }

                if ( $video->getRating( ) ) {
                    $v->appendChild( $doc->createElement( 'video:rating', $video->getRating( ) ) );
                }

                if ( $video->getViewCount( ) ) {
                    $v->appendChild( $doc->createElement( 'video:view_count', $video->getViewCount( ) ) );
                }

                if ( $video->getPublicationDate( ) ) {
                    $v->appendChild( $doc->createElement(
                        'video:publication_date',
                        $video->getPublicationDate( )->format( DATE_W3C )
                        )
                    );
                }

                if ( $video->getExpirationDate( ) ) {
                    $v->appendChild( $doc->createElement(
                        'video:expiration_date',
                        $video->getExpirationDate( )->format( DATE_W3C )
                    )
                    );
                }

                if ( count( $video->getTags( ) ) ) {
                    foreach( $video->getTags( ) as $tag ) {
                        $v->appendChild( $doc->createElement( 'video:tag', $tag ) );
                    }
                }

                if ( count( $video->getCategories( ) ) ) {
                    foreach( $video->getCategories( ) as $category ) {
                        $v->appendChild( $doc->createElement( 'video:category', $category ) );
                    }
                }

                if ( $video->getFamilyFriendly( ) ) {
                    $v->appendChild( $doc->createElement(
                        'video:family_friendly',
                        $video->isFamilyFriendly( ) ? 'yes' : 'no'
                    ) );
                }

                if ( $video->getRequiresSubscription( ) ) {
                    $v->appendChild( $doc->createElement(
                        'video:requires_subscription',
                        $video->requiresSubscription( ) ? 'yes' : 'no'
                    ) );
                }

                if ( $video->getLive( ) ) {
                    $v->appendChild( $doc->createElement(
                        'video:live',
                        $video->isLive( ) ? 'yes' : 'no'
                    ) );
                }

                if ( $video->getRestriction( ) ) {
                    $restriction = $doc->createElement(
                        'video:restriction',
                        implode( ' ', $video->getRestriction( )->getCountries( ) )
                    );
                    $restriction->setAttribute( 'relationship', $video->getRestriction( )->getRelationship( ) );
                    $v->appendChild( $restriction );
                }

                if ( $video->getPlatform( ) ) {
                    $platform = $doc->createElement(
                        'video:platform',
                        implode( ' ', $video->getPlatform( )->getPlatforms( ) )
                    );
                    $platform->setAttribute( 'relationship', $video->getPlatform( )->getRelationship( ) );
                    $v->appendChild( $platform );
                }

                if ( $video->getUploader( ) ) {
                    $uploader = $doc->createElement(
                        'video:uploader',
                        $video->getUploader( )->getName( )
                    );
                    if ( $video->getUploader( )->getInfo( ) ) {
                        $uploader->setAttribute( 'info', $video->getUploader( )->getInfo( ) );
                    }
                    $v->appendChild( $uploader );
                }

                $el->appendChild( $v );
            }
        }
    }
}
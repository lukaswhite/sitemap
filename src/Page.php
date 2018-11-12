<?php

namespace Lukaswhite\Sitemap;

use Carbon\Carbon;
use Lukaswhite\Sitemap\Exception\InvalidUrlException;
use Lukaswhite\Sitemap\Extensions\Image;
use Lukaswhite\Sitemap\Extensions\Video;

/**
 * Class Page
 *
 * Represents a page for the purposes of generating a sitemap.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Page implements \JsonSerializable
{
    /**
     * Class constants, that represent the change frequency
     */
    const CHANGE_FREQ_ALWAYS    =   'always';
    const CHANGE_FREQ_HOURLY    =   'hourly';
    const CHANGE_FREQ_DAILY     =   'daily';
    const CHANGE_FREQ_WEEKLY    =   'weekly';
    const CHANGE_FREQ_MONTHLY   =   'monthly';
    const CHANGE_FREQ_YEARLY    =   'yearly';
    const CHANGE_FREQ_NEVER     =   'never';

    /**
     * The URL of the page
     *
     * @var string
     */
    protected $url;

    /**
     * The page title
     *
     * @var string
     */
    protected $title;

    /**
     * The date that the page was last modified.
     *
     * @var Carbon
     */
    protected $lastModified;

    /**
     * The priority
     *
     * @var float
     */
    protected $priority       =   0.5;

    /**
     * The change frequency
     *
     * @var string
     */
    protected $changeFreq;

    /**
     * The ID of the page
     *
     * @var string
     */
    protected $id;

    /**
     * Any alternate URLs
     *
     * @var array
     */
    protected $alternateUrls = [ ];

    /**
     * Images that belong to this page
     *
     * @var array
     */
    protected $images = [ ];

    /**
     * Videos that belong to this page
     *
     * @var array
     */
    protected $videos = [ ];

    /**
     * Page constructor.
     *
     * @param string $url
     * @param string $title
     * @param Carbon $lastModified
     * @param float $priority
     * @param string $changeFreq
     * @throws InvalidUrlException
     */
    public function __construct( $url, $title = null, $lastModified = null, $priority = 0.5, $changeFreq = null )
    {
        $this->setUrl( $url );
        $this->setTitle( $title );

        if ( ! $lastModified ) {
            $lastModified = new \DateTime( );
        }

        $this->setLastModified( $lastModified );

        $this->setPriority( $priority );

        if ( $changeFreq ) {
            $this->setChangeFreq( $changeFreq );
        }
    }

    /**
     * Create an array representation of this page
     *
     * @return array
     */
    public function toArray( )
    {
        return [
            'url'               =>  $this->url,
            'title'             =>  $this->title,
            'lastModified'      =>  $this->lastModified ? $this->lastModified->format( 'Y-m-d' ) : null,
            'priority'          =>  $this->priority,
            'changeFreq'        =>  $this->changeFreq,
            'images'            =>  array_map(
                function( Image $image ) {
                    return $image->toArray( );
                },
                $this->images
            ),
            'videos'            =>  array_map(
                function( Video $video ) {
                    return $video->toArray( );
                },
                $this->videos
            ),
            'links'            =>  array_map(
                function( AlternateLink $link ) {
                    return $link->toArray( );
                },
                $this->alternateUrls
            ),
        ];
    }

    /**
     * Specifies the data that should be used to create a JSON representation
     * of this page.
     *
     * @return array
     */
    public function jsonSerialize( )
    {
        return $this->toArray( );
    }

    /**
     * Get the page's URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the URL of the page
     *
     * @param string $url
     * @return Page
     * @throws InvalidUrlException
     */
    public function setUrl( string $url ): Page
    {
        if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
            throw new InvalidUrlException( 'Invalid URL' );
        }

        $this->url = $url;
        return $this;
    }

    /**
     * Get the page's title
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the page
     *
     * @param string $title
     * @return Page
     */
    public function setTitle( ?string $title ): Page
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the date and time that the page was last modified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set the date and time that the page was last modified
     *
     * @param \DateTime $lastModified
     * @return Page
     */
    public function setLastModified( $lastModified )
    {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * Get the priority of the page.
     *
     * @return float
     */
    public function getPriority(): float
    {
        return $this->priority;
    }

    /**
     * Set the priority of the page
     *
     * @param float $priority
     * @return Page
     */
    public function setPriority( float $priority ): Page
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Get the frequency with which this page changes
     *
     * @return mixed
     */
    public function getChangeFreq()
    {
        return $this->changeFreq;
    }

    /**
     * Set the frequency with which the page changes
     *
     * @param mixed $changeFreq
     * @return Page
     */
    public function setChangeFreq( $changeFreq )
    {
        $this->changeFreq = $changeFreq;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Page
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Syntactic sugar for indicating that this page changes always
     *
     * @return $this
     */
    public function alwaysChanges( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_ALWAYS );
    }

    /**
     * Syntactic sugar for indicating that this page changes hourly
     *
     * @return $this
     */
    public function changesHourly( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_HOURLY );
    }

    /**
     * Syntactic sugar for indicating that this page changes daily
     *
     * @return $this
     */
    public function changesDaily( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_DAILY );
    }

    /**
     * Syntactic sugar for indicating that this page changes weekly
     *
     * @return $this
     */
    public function changesWeekly( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_WEEKLY );
    }

    /**
     * Syntactic sugar for indicating that this page changes monthly
     *
     * @return $this
     */
    public function changesMonthly( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_MONTHLY );
    }

    /**
     * Syntactic sugar for indicating that this page changes yearly
     *
     * @return $this
     */
    public function changesYearly( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_YEARLY );
    }

    /**
     * Syntactic sugar for indicating that this page never changes
     *
     * @return $this
     */
    public function neverChanges( )
    {
        return $this->setChangeFreq( self::CHANGE_FREQ_NEVER );
    }

    /**
     * Add an alternate
     *
     * @param string $url
     * @param string $language
     * @return self
     */
    public function addAlternate( string $url, string $language )
    {
        $this->alternateUrls[ ] = new AlternateLink( $url, $language );
    }

    /**
     * Get the alternate links
     *
     * @return array
     */
    public function getAlternates( ) : array
    {
        return $this->alternateUrls;
    }

    /**
     * Add an image to the page
     *
     * @param Image $image
     * @return Page
     */
    public function addImage( Image $image ) : self
    {
        $this->images[ ] = $image;
        return $this;
    }

    /**
     * Get the images
     *
     * @return array
     */
    public function getImages( ) : array
    {
        return $this->images;
    }

    /**
     * Add a video to the page
     *
     * @param Video $video
     * @return Page
     */
    public function addVideo( Video $video ) : self
    {
        $this->videos[ ] = $video;
        return $this;
    }

    /**
     * Get the videos
     *
     * @return array
     */
    public function getVideos( ) : array
    {
        return $this->videos;
    }

}
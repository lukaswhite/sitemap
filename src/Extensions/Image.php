<?php

namespace Lukaswhite\Sitemap\Extensions;

/**
 * Class Image
 *
 * Represents an image, for use within a sitemap
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Image implements \JsonSerializable
{
    /**
     * The location of the image
     *
     * @var string
     */
    protected $location;

    /**
     * The image's caption, if applicable
     *
     * @var string
     */
    protected $caption;

    /**
     * An optional title of the image
     *
     * @var string
     */
    protected $title;

    /**
     * A geo-location for the image
     *
     * @var string
     */
    protected $geoLocation;

    /**
     * A URL to the license for the image
     *
     * @var string
     */
    protected $license;

    /**
     * Image constructor.
     *
     * @param string $location
     */
    public function __construct( string $location )
    {
        $this->location = $location;
    }

    /**
     * Create an array representation of this image
     *
     * @return array
     */
    public function toArray( ) : array
    {
        return [
            'location'          =>  $this->location,
            'caption'           =>  $this->caption,
            'title'             =>  $this->title,
            'geoLocation'       =>  $this->geoLocation,
            'license'           =>  $this->license,
        ];
    }

    /**
     * Specifies the data that should be used to create a JSON representation
     * of this image.
     *
     * @return array
     */
    public function jsonSerialize( )
    {
        return $this->toArray( );
    }

    /**
     * Get the location (URL) of the image
     *
     * @return string
     */
    public function getLocation( ) : string
    {
        return $this->location;
    }

    /**
     * Set the location (URL) of the image
     *
     * @param string $location
     * @return Image
     */
    public function setLocation( $location ) : self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get the caption for the image
     *
     * @return string
     */
    public function getCaption( ) : string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     * @return Image
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    /**
     * @param string $geoLocation
     * @return Image
     */
    public function setGeoLocation($geoLocation)
    {
        $this->geoLocation = $geoLocation;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param string $license
     * @return Image
     */
    public function setLicense($license)
    {
        $this->license = $license;
        return $this;
    }

}
<?php

namespace Lukaswhite\Sitemap\Support\Video;


/**
 * Class Player
 *
 * @package Lukaswhite\Sitemap\Support\Video
 */
class Player
{
    /**
     * The location
     *
     * @var string
     */
    protected $location;

    /**
     * Whether embedding is allowed
     *
     * @var bool
     */
    protected $allowEmbed;

    /**
     * Platform constructor.
     *
     * @param string $location,
     * @param bool $allowEmbed
     */
    public function __construct( string $location, bool $allowEmbed = null )
    {
        $this->setLocation( $location );
        $this->setAllowEmbed( $allowEmbed );
    }

    /**
     * @return string
     */
    public function getLocation( ) : string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Player
     */
    public function setLocation( string $location ) : ?self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get the value for allowing embedding. Note that this isn't a boolean, because it's an optional
     * attribute and therefore might not be set.
     *
     * @return bool
     */
    public function getAllowEmed( ) : ?bool
    {
        return !! $this->allowEmbed;
    }

    /**
     * Determine whether embedding is allowed
     *
     * @return bool
     */
    public function allowsEmbedding( ) : bool
    {
        return !! $this->allowEmbed;
    }

    /**
     * @param bool $allowEmbed
     * @return Player
     */
    public function setAllowEmbed( ?bool $allowEmbed ) : self
    {
        $this->allowEmbed = $allowEmbed;
        return $this;
    }

    /**
     * Create an array representation of this platform
     *
     * @return array
     */
    public function toArray( ) : array
    {
        $data = [
            'location'         =>  $this->location
        ];

        if ( $this->getAllowEmed( ) ) {
            $data[ 'allowEmbed' ] = $this->allowsEmbedding( );
        }

        return $data;
    }
}
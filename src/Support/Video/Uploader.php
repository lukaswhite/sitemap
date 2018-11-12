<?php

namespace Lukaswhite\Sitemap\Support\Video;

/**
 * Class Uploader
 * 
 * @package Lukaswhite\Sitemap\Support\Video
 */
class Uploader
{
    /**
     * The name of the uploader
     *
     * @var string
     */
    protected $name;

    /**
     * Optional info about the uploader (a URL)
     *
     * @var string
     */
    protected $info;

    /**
     * Uploader constructor.
     *
     * @param string $name
     * @param string|null $info
     */
    public function __construct( string $name, string $info = null )
    {
        $this->setName( $name );
        $this->setInfo( $info );
    }

    /**
     * @return string
     */
    public function getName( ) : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Uploader
     */
    public function setName( $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getInfo( ) : ?string
    {
        return $this->info;
    }

    /**
     * @param string $info
     * @return Uploader
     */
    public function setInfo( ?string $info ) : self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * Create an array representation of this uploader
     *
     * @return array
     */
    public function toArray( ) : array
    {
        $data = [
            'name'          =>  $this->name,
        ];

        if ( $this->info ) {
            $data[ 'info' ] = $this->info;
        }

        return $data;

    }
}
<?php

namespace Lukaswhite\Sitemap\Writer;

use Lukaswhite\Sitemap\Sitemap;

/**
 * Class AbstractWriter
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
abstract class AbstractWriter
{
    /**
     * The sitemap
     *
     * @var Sitemap
     */
    protected $sitemap;

    /**
     * AbstractWriter constructor.
     *
     * @param Sitemap $sitemap
     */
    public function __construct( Sitemap $sitemap )
    {
        $this->sitemap = $sitemap;
    }

    /**
     * Write to a string
     *
     * @return string
     */
    abstract public function write( ) : string;

    /**
     * Save the sitemap to the filesystem
     *
     * @param string $filepath
     * @return bool
     */
    public function save( $filepath )
    {
        return file_put_contents( $filepath, $this->write( ) );
    }

    /**
     * Create a string representation of the sitemap
     *
     * @return string
     */
    public function toString( )
    {
        return ( string ) $this->write( );
    }

    /**
     * Magic to string method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString( );
    }

}
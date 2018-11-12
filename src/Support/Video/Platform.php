<?php

namespace Lukaswhite\Sitemap\Support\Video;
use Lukaswhite\Sitemap\Contracts\Restricts;

/**
 * Class Platform
 *
 * @package Lukaswhite\Sitemap\Support\Video
 */
class Platform implements Restricts
{
    use \Lukaswhite\Sitemap\Support\Restricts;

    /**
     * Class constants
     */
    const WEB               =   'web';
    const MOBILE            =   'mobile';
    const TV                =   'tv';

    /**
     * The platforms
     *
     * @var array
     */
    protected $platforms = [ ];

    /**
     * Platform constructor.
     *
     * @param array $platforms
     */
    public function __construct( ...$platforms )
    {
        $this->setPlatforms( $platforms );
    }

    /**
     * Convenience method for creating an instance that allows the specified platforms.
     *
     * @param ...$platforms
     * @return self
     */
    public static function allowsPlatforms( ...$platforms )
    {
        return ( new self( ) )->setPlatforms( $platforms )->allows( );
    }

    /**
     * Convenience method for creating an instance that allows the specified platforms.
     *
     * @param ...$platforms
     * @return self
     */
    public static function deniesPlatforms( ...$platforms )
    {
        return ( new self( ) )->setPlatforms( $platforms )->denies( );
    }

    /**
     * Convenience method for creating an instance that only allows the web.
     *
     * @return self
     */
    public static function onlyAllowsWeb( )
    {
        return ( new self( ) )->setPlatforms( [ self::WEB ] )->allows( );
    }

    /**
     * Convenience method for creating an instance that only allows mobile.
     *
     * @return self
     */
    public static function onlyAllowsMobile( )
    {
        return ( new self( ) )->setPlatforms( [ self::MOBILE ] )->allows( );
    }

    /**
     * Convenience method for creating an instance that only allows TV.
     *
     * @return self
     */
    public static function onlyAllowsTV( )
    {
        return ( new self( ) )->setPlatforms( [ self::TV ] )->allows( );
    }

    /**
     * Convenience method for creating an instance that only allows the web and mobile.
     *
     * @return self
     */
    public static function onlyAllowsWebAndMobile( )
    {
        return ( new self( ) )->setPlatforms( [ self::WEB, self::MOBILE ] )->allows( );
    }

    /**
     * Convenience method for creating an instance that only allows the web and TV.
     *
     * @return self
     */
    public static function onlyAllowsWebAndTV( )
    {
        return ( new self( ) )->setPlatforms( [ self::WEB, self::TV ] )->allows( );
    }

    /**
     * Convenience method for creating an instance that only allows mobile and TV.
     *
     * @return self
     */
    public static function onlyAllowsMobileandTV( )
    {
        return ( new self( ) )->setPlatforms( [ self::MOBILE, self::TV ] )->allows( );
    }

    /**
     * @return array
     */
    public function getPlatforms( ) : array
    {
        return $this->platforms;
    }

    /**
     * @param array $platforms
     * @return self
     */
    public function setPlatforms( array $platforms ) : self
    {
        $this->platforms = $platforms;
        return $this;
    }

    /**
     * Create an array representation of this platform
     *
     * @return array
     */
    public function toArray( ) : array
    {
        return [
            'platforms'         =>  $this->platforms,
            'relationship'      =>  $this->relationship,
        ];
    }
}
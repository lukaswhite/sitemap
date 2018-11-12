<?php

namespace Lukaswhite\Sitemap\Support\Video;
use Lukaswhite\Sitemap\Contracts\Restricts;

/**
 * Class Restriction
 *
 * @package Lukaswhite\Sitemap\Support\Video
 */
class Restriction implements Restricts
{
    use \Lukaswhite\Sitemap\Support\Restricts;

    /**
     * The countries that the restriction applies to
     *
     * @var array
     */
    protected $countries = [ ];

    /**
     * Restriction constructor.
     *
     * @param string ...$countries
     */
    public function __construct( ...$countries )
    {
        $this->setCountries( $countries );
    }

    /**
     * Convenience method for creating an instance that allows the specified countries.
     *
     * @param ...$countries
     * @return self
     */
    public static function allowedIn( ...$countries )
    {
        return ( new self( ) )->setCountries( $countries )->allows( );
    }

    /**
     * Convenience method for creating an instance that allows the specified countries.
     *
     * @param ...$countries
     * @return self
     */
    public static function deniedIn( ...$countries )
    {
        return ( new self( ) )->setCountries( $countries )->denies( );
    }

    /**
     * @return array
     */
    public function getCountries( ) : array
    {
        return $this->countries;
    }

    /**
     * @param array $countries
     * @return Restriction
     */
    public function setCountries( array $countries ) : self
    {
        $this->countries = $countries;
        return $this;
    }

    /**
     * Create an array representation of this restriction
     *
     * @return array
     */
    public function toArray( ) : array
    {
        return [
            'countries'         =>  $this->countries,
            'relationship'      =>  $this->relationship,
        ];
    }
}
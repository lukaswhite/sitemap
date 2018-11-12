<?php

namespace Lukaswhite\Sitemap;

/**
 * Class AlternateLink
 *
 * Represents an alternate link
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class AlternateLink
{
    /**
     * The URL
     *
     * @var string
     */
    protected $url;

    /**
     * The language
     *
     * @var string
     */
    protected $language;

    /**
     * AlternateLink constructor.
     *
     * @param string $url
     * @param string $language
     */
    public function __construct( $url, $language )
    {
        $this->url = $url;
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getUrl( ) : string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return AlternateLink
     */
    public function setUrl( string $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage( ) : string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return AlternateLink
     */
    public function setLanguage( string $language ) : self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Create an array representation of this link
     *
     * @return array
     */
    public function toArray( ) : array
    {
        return [
            'url'       =>  $this->url,
            'language'  =>  $this->language,
        ];
    }


}
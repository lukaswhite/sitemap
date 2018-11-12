<?php

namespace Lukaswhite\Sitemap\Writer;

/**
 * Class Json
 *
 * This class is used to write a sitemap in JSON format.
 *
 * Although JSON sitemaps aren't used, this might be useful for reporting purposes. For example,
 * in the back-end of your application you may wish to display the current sitemap as a list, rendered
 * from data retrieved via an API call.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Json extends AbstractWriter
{
    /**
     * Write to a string
     *
     * @return string
     */
    public function write( ) : string
    {
        return json_encode( $this->sitemap );
    }
}
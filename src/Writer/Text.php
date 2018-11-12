<?php

namespace Lukaswhite\Sitemap\Writer;

use Lukaswhite\Sitemap\Page;

/**
 * Class Text
 *
 * This class is used to write a sitemap in text format.
 *
 * The format is incredibly simple; it's simply the URLs that make up the sitemap,
 * one per line, in plain text format.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Text extends AbstractWriter
{
    /**
     * Write to a string
     *
     * @return string
     */
    public function write( ) : string
    {
        return implode( "\n",
            array_map(
                function( Page $page ) {
                    return $page->getUrl( );
                },
                $this->sitemap->getPages( )
            )
        );
    }
}
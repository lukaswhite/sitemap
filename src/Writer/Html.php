<?php

namespace Lukaswhite\Sitemap\Writer;

use Lukaswhite\Sitemap\Page;

/**
 * Class Html
 *
 * This class is used to write a sitemap as HTML
 *
 * The format is incredibly simple; it's simply the URLs that make up the sitemap,
 * one per line, in plain text format.
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Html extends AbstractWriter
{
    /**
     * Write to HTML
     *
     * @return string
     */
    public function write( ) : string
    {
        $items = implode( "\n",
            array_map(
                function( Page $page ) {
                    return sprintf(
                        '<li>%s</li>',
                        ( $page->getTitle( ) ) ?
                            sprintf(
                                '<a href="%s" title="%s">%s</a>',
                                $page->getUrl( ),
                                $page->getTitle( ),
                                $page->getTitle( )
                            ) :
                            sprintf(
                                '<a href="%s">%s</a>',
                                $page->getUrl( ),
                                $page->getUrl( )
                            )
                    );
                },
                $this->sitemap->getPages( )
            )
        );

        return "<ul>\n" . $items . "</ul>";
    }
}
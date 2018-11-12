<?php

class SitemapListTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingSitemapList( )
    {
        $list = new \Lukaswhite\Sitemap\SitemapList( );
        $list
            ->addSitemap(
                ( new \Lukaswhite\Sitemap\Sitemap( ) )->setLocation(
                    'http://example.com/sitemap1.xml'
                )->setLastModified( ( new \DateTime( ) )->setDate( 2018, 11, 20 ) )
            )
            ->addSitemap(
                ( new \Lukaswhite\Sitemap\Sitemap( ) )->setLocation(
                    'http://example.com/sitemap2.xml'
                )->setLastModified( ( new \DateTime( ) )->setDate( 2018, 11, 24 ) )
            );

        $this->assertEquals( 2, count( $list->getSitemaps( ) ) );

        $sitemap = $list->getSitemaps( )[ 0 ];
        /** @var \Lukaswhite\Sitemap\Sitemap $sitemap */
        $this->assertEquals( 'http://example.com/sitemap1.xml', $sitemap->getLocation( ) );
        $this->assertEquals( '2018-11-20', $sitemap->getLastModified( )->format( 'Y-m-d' ) );

        $xml = $list->write( );

        $this->assertEquals( $xml, file_get_contents( __DIR__ . '/fixtures/list.xml' ) );
    }
}
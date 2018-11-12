<?php

class RSSWriterTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingSitemap( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $firstPage->addAlternate( 'http://www.example.com/de', 'de' );
        $firstPage->addAlternate( 'http://www.example.com/es', 'es' );

        $firstPage->addImage(
        ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
            ->setCaption( 'Test image caption' )
            ->setTitle( 'Test image title' )
            ->setGeoLocation( 'Earth' )
            ->setLicense( 'http://www.example.com/license.html' )
        );

        $sitemap
            ->addPage( $firstPage )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/about',
                    'About',
                    ( new \DateTime( ) )->setDate( 2018, 11, 15 ),
                    0.8
                )
            );

        $sitemap->setLocation( 'http://www.example.com/sitemap.rss' );
        $sitemap->setLastModified(
            ( new \DateTime( ) )->setDate( 2018, 11, 15 )->setTime( 9, 45, 0 )
        );

        $writer = new \Lukaswhite\Sitemap\Writer\RSS( $sitemap );

        $feed = $writer->write( );

        $this->assertEquals( file_get_contents( __DIR__ . '/fixtures/rss.xml' ), $feed );
    }

    public function testCreatingSitemapWithCustomMeta( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $firstPage->addAlternate( 'http://www.example.com/de', 'de' );
        $firstPage->addAlternate( 'http://www.example.com/es', 'es' );

        $firstPage->addImage(
            ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
                ->setCaption( 'Test image caption' )
                ->setTitle( 'Test image title' )
                ->setGeoLocation( 'Earth' )
                ->setLicense( 'http://www.example.com/license.html' )
        );

        $sitemap
            ->addPage( $firstPage )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/about',
                    'About',
                    ( new \DateTime( ) )->setDate( 2018, 11, 15 ),
                    0.8
                )
            );

        $sitemap->setLocation( 'http://www.example.com/sitemap.rss' );
        $sitemap->setLastModified(
            ( new \DateTime( ) )->setDate( 2018, 11, 15 )->setTime( 9, 45, 0 )
        );

        $writer = new \Lukaswhite\Sitemap\Writer\RSS( $sitemap );
        $writer->setChannelTitle( 'My Sitemap' );
        $writer->setChannelDescription( 'This is a sitemap' );

        $feed = $writer->write( );

        $this->assertEquals( file_get_contents( __DIR__ . '/fixtures/rss-custom-meta.xml' ), $feed );
    }




}
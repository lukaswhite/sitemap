<?php

class AtomWriterTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingSitemap( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 )->setTime( 1, 30, 0 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $firstPage->addAlternate( 'http://www.example.com/de', 'de' );
        $firstPage->addAlternate( 'http://www.example.com/es', 'es' );

        $firstPage->setId( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' );

        $firstPage->addImage(
        ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
            ->setCaption( 'Test image caption' )
            ->setTitle( 'Test image title' )
            ->setGeoLocation( 'Earth' )
            ->setLicense( 'http://www.example.com/license.html' )
        );

        $secondPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com/about',
            'About',
            ( new \DateTime( ) )->setDate( 2018, 11, 15 )->setTime( 9, 45, 0 ),
            0.8
        );

        $secondPage->setId( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-8768787dfa6a' );

        $sitemap
            ->addPage( $firstPage )
            ->addPage( $secondPage );

        $sitemap->setLocation( 'http://www.example.com/sitemap.atom' );
        $sitemap->setLastModified(
            ( new \DateTime( ) )->setDate( 2018, 11, 15 )->setTime( 9, 45, 0 )
        );


        $writer = new \Lukaswhite\Sitemap\Writer\Atom( $sitemap );

        $writer->setFeedTitle( 'My Atom Sitemap Feed' );
        $writer->setFeedAuthor( 'Bob', 'bob@example.com' );

        $feed = $writer->write( );

        $this->assertEquals( file_get_contents( __DIR__ . '/fixtures/atom.xml' ), $feed );

        $writer->setFeedId( 'my-custom-feed-id' );
        $this->assertEquals(
            file_get_contents( __DIR__ . '/fixtures/atom-custom-id.xml' ), $writer->write( )
        );

    }


}
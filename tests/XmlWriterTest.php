<?php

class XmlWriterTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingSitemap( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 )->setTime( 10, 20, 0 ),
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
                    ( new \DateTime( ) )->setDate( 2018, 11, 15 )->setTime( 9, 15, 12 ),
                    0.8
                )
            );

        $writer = new \Lukaswhite\Sitemap\Writer\Xml( $sitemap );

        $writer->addXslStylesheet( 'http://example.com/styles.xsl' );

        $writer->addComment( 'Comment 1' );
        $writer->addComment( 'Comment 2' );

        $xml = $writer->write( );

        $this->assertTrue( true );

        $this->assertTrue( strpos(
            $xml,
            '<?xml-stylesheet type="text/xsl" href="http://example.com/styles.xsl"?>'
            ) !== false
        );

        $this->assertTrue( strpos( $xml, '<!--Comment 1-->' ) !== false );
        $this->assertTrue( strpos( $xml, '<!--Comment 2-->' ) !== false );

        $this->assertEquals( file_get_contents( __DIR__ . '/fixtures/sitemap.xml' ), $xml );

    }

    public function testSavingToFile( )
    {
        $filepath = tempnam( sys_get_temp_dir( ), 'xmlsitemap_' );
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 )->setTime( 10, 20, 0 ),
            1
        );

        $firstPage->addAlternate( 'http://www.example.com/de', 'de' );
        $firstPage->addAlternate( 'http://www.example.com/es', 'es' );

        $writer = new \Lukaswhite\Sitemap\Writer\Xml( $sitemap );

        $writer->save( $filepath );
        $this->assertFileExists( $filepath );
        $this->assertEquals( $writer->write( ), file_get_contents( $filepath ) );
        unlink( $filepath );

    }

}
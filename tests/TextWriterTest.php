<?php

class TextWriterTest extends \PHPUnit\Framework\TestCase
{
    public function testWritingTextSitemap( )
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

        $writer = new \Lukaswhite\Sitemap\Writer\Text( $sitemap );

        $results = $writer->write( );

        $this->assertEquals( "http://www.example.com\nhttp://www.example.com/about", $results );

        $this->assertEquals( $results, $writer->toString( ) );
        $this->assertEquals( $results, ( string ) $writer );
    }

    public function testSavingToFile( )
    {
        $filepath = tempnam( sys_get_temp_dir( ), 'xmlsitemap_' );
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1
        );

        $firstPage->addAlternate( 'http://www.example.com/de', 'de' );
        $firstPage->addAlternate( 'http://www.example.com/es', 'es' );

        $writer = new \Lukaswhite\Sitemap\Writer\Text( $sitemap );

        $writer->save( $filepath );
        $this->assertFileExists( $filepath );
        $this->assertEquals( $writer->write( ), file_get_contents( $filepath ) );
        unlink( $filepath );

    }

}
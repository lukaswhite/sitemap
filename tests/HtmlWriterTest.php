<?php

class HtmlWriterTest extends \PHPUnit\Framework\TestCase
{
    public function testWritingHtmlSitemap( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $firstPage = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $sitemap
            ->addPage( $firstPage )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/about',
                    null,
                    ( new \DateTime( ) )->setDate( 2018, 11, 15 ),
                    0.8
                )
            );

        $writer = new \Lukaswhite\Sitemap\Writer\Html( $sitemap );

        $html = $writer->write( );

        $this->assertEquals( '<ul>', substr( $html, 0, 4 ) );

        $this->assertEquals( '</ul>', substr( $html, -5 ) );

        $this->assertTrue(
            strpos(
                $html,
                '<a href="http://www.example.com" title="Homepage">Homepage</a>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $html,
                '<a href="http://www.example.com/about">http://www.example.com/about</a>'
            ) > -1
        );

    }

}
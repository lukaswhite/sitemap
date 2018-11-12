<?php

class SitemapTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingSitemap( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );
        $sitemap
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com',
                    'Homepage',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    1
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/about',
                    'About',
                    ( new \DateTime( ) )->setDate( 2018, 11, 15 ),
                    0.8
                )
            );

        $this->assertEquals( 2, count( $sitemap->getPages( ) ) );

        $page = $sitemap->getPages( )[ 0 ];

        $this->assertInstanceOf( \Lukaswhite\Sitemap\Page::class, $page );
        /** @var \Lukaswhite\Sitemap\Page $page */
        $this->assertEquals( 'http://www.example.com', $page->getUrl( ) );
        $this->assertEquals( 'Homepage', $page->getTitle( ) );
        $this->assertEquals( '2018-11-20', $page->getLastModified( )->format( 'Y-m-d' ) );
        $this->assertEquals( 1, $page->getPriority( ) );
    }

    public function testAddingMultiplePages( )
    {
        $sitemap = $this->createSitemap( );
        $sitemap->addPages(
            [
                new \Lukaswhite\Sitemap\Page( 'http://example.com/page1', 'Page 1' ),
                new \Lukaswhite\Sitemap\Page( 'http://example.com/page2', 'Page 2' ),
                new \Lukaswhite\Sitemap\Page( 'http://example.com/page3', 'Page 3' )
            ]
        );
        $this->assertEquals( 5, count( $sitemap->getPages( ) ) );
    }

    public function testToArray( )
    {
        $sitemap = $this->createSitemap( );
        $arr = $sitemap->toArray( );
        $this->assertEquals( 2, count( $arr ) );
        $page = $arr[ 0 ];
        $this->assertArrayHasKey( 'url', $page );
        $this->assertEquals( 'http://www.example.com', $page[ 'url' ] );
        $this->assertArrayHasKey( 'title', $page );
        $this->assertEquals( 'Homepage', $page[ 'title' ] );
        $this->assertArrayHasKey( 'lastModified', $page );
        $this->assertEquals( '2018-11-20', $page[ 'lastModified' ] );
        $this->assertArrayHasKey( 'priority', $page );
        $this->assertEquals( '1', $page[ 'priority' ] );
    }

    public function testCreatingJsonRepresentation( )
    {
        $sitemap = $this->createSitemap( );
        $this->assertEquals( $sitemap->toArray( ), json_decode( json_encode( $sitemap ), true ) );
    }

    public function testSortingByPriority( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $sitemap
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/low',
                    'Low priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.3
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/high',
                    'High priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.8
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/medium',
                    'Medium priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.5
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/highest',
                    'Highest priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    1
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/medium2',
                    'Medium priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.5
                )
            );

        $sitemap->sortByPriority( );

        $pages = $sitemap->getPages( );
        $this->assertEquals( 1, $pages[ 0 ]->getPriority( ) );
        $this->assertEquals( 0.8, $pages[ 1 ]->getPriority( ) );
        $this->assertEquals( 0.5, $pages[ 2 ]->getPriority( ) );
        $this->assertEquals( 0.5, $pages[ 3 ]->getPriority( ) );
        $this->assertEquals( 0.3, $pages[ 4 ]->getPriority( ) );
    }

    public function testSortingByTitle( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );

        $sitemap
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/low',
                    'Low priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.3
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/high',
                    'High priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.8
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/medium',
                    'Medium priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.5
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/highest',
                    'Highest priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    1
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/medium2',
                    'Medium priority',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    0.5
                )
            );

        $sitemap->sortByTitle( );

        $pages = $sitemap->getPages( );
        $this->assertEquals( 'High priority', $pages[ 0 ]->getTitle( ) );
        $this->assertEquals( 'Highest priority', $pages[ 1 ]->getTitle( ) );
        $this->assertEquals( 'Low priority', $pages[ 2 ]->getTitle( ) );
        $this->assertEquals( 'Medium priority', $pages[ 3 ]->getTitle( ) );
        $this->assertEquals( 'Medium priority', $pages[ 4 ]->getTitle( ) );
    }

    protected function createSitemap( )
    {
        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );
        $sitemap
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com',
                    'Homepage',
                    ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
                    1
                )
            )
            ->addPage(
                new \Lukaswhite\Sitemap\Page(
                    'http://www.example.com/about',
                    'About',
                    ( new \DateTime( ) )->setDate( 2018, 11, 15 ),
                    0.8
                )
            );
        return $sitemap;
    }
}
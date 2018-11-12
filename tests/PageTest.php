<?php

class PageTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingPage( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1
        );

        $this->assertEquals( 'http://www.example.com', $page->getUrl( ) );
        $this->assertEquals( 'Homepage', $page->getTitle( ) );
        $this->assertEquals( '2018-11-20', $page->getLastModified( )->format( 'Y-m-d' ) );
        $this->assertEquals( 1, $page->getPriority( ) );
    }

    public function testChangeFrequencyConstants( )
    {
        $this->assertEquals( 'always', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_ALWAYS );
        $this->assertEquals( 'yearly', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_YEARLY );
        $this->assertEquals( 'monthly', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY );
        $this->assertEquals( 'weekly', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_WEEKLY );
        $this->assertEquals( 'daily', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_DAILY );
        $this->assertEquals( 'hourly', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_HOURLY );
        $this->assertEquals( 'never', \Lukaswhite\Sitemap\Page::CHANGE_FREQ_NEVER );
    }

    public function testSettingFrequencyUsingConvenienceMethods( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $page->alwaysChanges( );
        $this->assertEquals( 'always', $page->getChangeFreq( ) );

        $page->changesYearly( );
        $this->assertEquals( 'yearly', $page->getChangeFreq( ) );

        $page->changesMonthly( );
        $this->assertEquals( 'monthly', $page->getChangeFreq( ) );

        $page->changesWeekly( );
        $this->assertEquals( 'weekly', $page->getChangeFreq( ) );

        $page->changesDaily( );
        $this->assertEquals( 'daily', $page->getChangeFreq( ) );

        $page->changesHourly( );
        $this->assertEquals( 'hourly', $page->getChangeFreq( ) );

        $page->neverChanges( );
        $this->assertEquals( 'never', $page->getChangeFreq( ) );
    }

    public function testCanSerializepageToJson( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $this->assertEquals( $page->toArray( ), json_decode( json_encode( $page ), true ) );
    }

    public function testAddingImages( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1,
            \Lukaswhite\Sitemap\Page::CHANGE_FREQ_MONTHLY
        );

        $page->addImage(
            ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
            ->setCaption( 'Test image caption' )
            ->setTitle( 'Test image title' )
            ->setGeoLocation( 'Earth' )
            ->setLicense( 'http://www.example.com/license.html' )
        );

        $page->addImage(
            ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image2.jpg' ) )
                ->setCaption( 'Test image caption 2' )
                ->setTitle( 'Test image title 2' )
                ->setGeoLocation( 'Milky Way' )
                ->setLicense( 'http://www.example.com/license.html' )
        );

        $this->assertEquals( 2, count( $page->getImages( ) ) );

        $image = $page->getImages( )[ 0 ];

        $this->assertInstanceOf( \Lukaswhite\Sitemap\Extensions\Image::class, $image );
        /** @var \Lukaswhite\Sitemap\Image $image  */
        $this->assertEquals( 'http://www.example.com/image1.jpg', $image->getLocation( ) );
        $this->assertEquals( 'Test image caption', $image->getCaption( ) );
        $this->assertEquals( 'Test image title', $image->getTitle( ) );
        $this->assertEquals( 'Earth', $image->getGeoLocation( ) );
        $this->assertEquals( 'http://www.example.com/license.html', $image->getLicense( ) );

        $arr = $page->toArray( );
        $this->assertArrayHasKey( 'images', $arr );
        $this->assertTrue( is_array( $arr[ 'images' ] ) );
        $this->assertEquals( 2, count( $arr[ 'images' ] ) );
        $imageArray = $arr[ 'images' ][ 0 ];
        $this->assertTrue( is_array( $imageArray ) );
        $this->assertArrayHasKey( 'location', $imageArray );
        $this->assertEquals( 'http://www.example.com/image1.jpg', $imageArray[ 'location' ] );

    }

    public function testPageHasMediumPriorityByDefault( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage'
        );

        $this->assertEquals( 0.5, $page->getPriority( ) );
    }

    public function testPageHasNoDefaultChangeFrequency( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage'
        );

        $this->assertNull( $page->getChangeFreq( ) );
    }

    public function testAddingAlternateUrls( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'http://www.example.com',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1
        );

        $page->addAlternate( 'http://www.example.com/de', 'de' );
        $page->addAlternate( 'http://www.example.com/en-ie', 'en-IE' );

        $this->assertEquals( 2, count( $page->getAlternates( ) ) );
        $german = $page->getAlternates( )[ 0 ];
        /** @var \Lukaswhite\Sitemap\AlternateLink $german */
        $this->assertEquals( 'http://www.example.com/de', $german->getUrl( ) );
        $this->assertEquals( 'de', $german->getLanguage( ) );

        $alternate = new \Lukaswhite\Sitemap\AlternateLink( 'http://www.example.com/de', 'de' );
        $alternate->setUrl( 'http://www.example.com/es' )
            ->setLanguage( 'es' );
        $this->assertEquals( 'http://www.example.com/es', $alternate->getUrl( ) );
        $this->assertEquals( 'es', $alternate->getLanguage( ) );
    }

    /**
     * @expectedException \Lukaswhite\Sitemap\Exception\InvalidUrlException
     */
    public function testExceptionThrownIfUrlIsInvalid( )
    {
        $page = new \Lukaswhite\Sitemap\Page(
            'not a url',
            'Homepage',
            ( new \DateTime( ) )->setDate( 2018, 11, 20 ),
            1
        );
    }


}
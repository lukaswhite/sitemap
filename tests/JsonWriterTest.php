<?php

class JsonWriterTest extends \PHPUnit\Framework\TestCase
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

        $firstPage->addImage(
            new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image.jpg' )
        );

        $firstPage->addVideo(
            ( new \Lukaswhite\Sitemap\Extensions\Video(  ) )
                ->setTitle( 'Grilling steaks for summer' )
                ->setDescription( 'Alkis shows you how to get perfectly done steaks every time' )
                ->setContentLocation( 'http://streamserver.example.com/video123.mp4' )
                ->setPlayer(
                    new \Lukaswhite\Sitemap\Support\Video\Player(
                        'http://www.example.com/videoplayer.php?video=123',
                        true
                    )
                )
                ->setDuration(600 )
                ->setExpirationDate(
                    ( new \DateTime( ) )->setDate( 2021, 11, 05 )
                        ->setTime( 19, 20, 30 )
                )
                ->setPublicationDate(
                    ( new \DateTime( ) )->setDate( 2007, 11, 05 )
                        ->setTime( 19, 20, 30 )
                )
                ->setRating( 4.2 )
                ->setPrice(
                    ( new \Lukaswhite\Sitemap\Support\Video\Price( 1.99, 'EUR' ) )
                        ->setType( \Lukaswhite\Sitemap\Support\Video\Price::OWN )
                        ->setResolution( \Lukaswhite\Sitemap\Support\Video\Price::HD )
                )
                ->addRestriction(
                    ( new \Lukaswhite\Sitemap\Support\Video\Restriction( 'IE', 'GB', 'US', 'CA' ) )
                        ->allows( )
                )
                ->setPlatform(
                    ( new \Lukaswhite\Sitemap\Support\Video\Platform(
                        \Lukaswhite\Sitemap\Support\Video\Platform::TV,
                        \Lukaswhite\Sitemap\Support\Video\Platform::WEB
                    ) )
                        ->denies( )
                )
                ->setLive( )
                ->setFamilyFriendly( )
                ->setRequiresSubscription( )
                ->setViewCount( 1000 )
                ->setTags( 'steak', 'grilling', 'summer' )
                ->setCategories( 'Cooking', 'Beef' )
                ->setUploader(
                    new \Lukaswhite\Sitemap\Support\Video\Uploader(
                        'GrillyMcGrillerson',
                        'http://www.example.com/users/grillymcgrillerson'
                    )
                )
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

        $writer = new \Lukaswhite\Sitemap\Writer\Json( $sitemap );

        $json = $writer->write( );

        $decoded = json_decode( $json, true );

        $this->assertEquals( 2, count( $decoded ) );
        $this->assertArrayHasKey( 'url', $decoded[ 0 ] );
        $this->assertEquals( 'http://www.example.com', $decoded[ 0 ][ 'url' ] );
        $this->assertArrayHasKey( 'images', $decoded[ 0 ] );
        $this->assertTrue( is_array( $decoded[ 0 ][ 'images' ] ) );
        $this->assertEquals( 1, count( $decoded[ 0 ][ 'images' ] ) );
        $this->assertArrayHasKey( 'location', $decoded[ 0 ][ 'images' ][ 0 ] );
        $this->assertEquals( 'http://www.example.com/image.jpg', $decoded[ 0 ][ 'images' ][ 0 ][ 'location' ] );
        $this->assertTrue( is_array( $decoded[ 0 ][ 'links' ] ) );
        $this->assertEquals( 2, count( $decoded[ 0 ][ 'links' ] ) );
        $this->assertArrayHasKey( 'url', $decoded[ 0 ][ 'links' ][ 0 ] );
        $this->assertEquals( 'http://www.example.com/de', $decoded[ 0 ][ 'links' ][ 0 ][ 'url' ] );
        $this->assertArrayHasKey( 'contentLocation', $decoded[ 0 ][ 'videos' ][ 0 ] );
    }

}
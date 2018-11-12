<?php

class ImageTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingImage( )
    {
        $image =
            ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
            ->setCaption( 'Test image caption' )
            ->setTitle( 'Test image title' )
            ->setGeoLocation( 'Earth' )
            ->setLicense( 'http://www.example.com/license.html' );

        $this->assertEquals( 'http://www.example.com/image1.jpg', $image->getLocation( ) );
        $this->assertEquals( 'Test image caption', $image->getCaption( ) );
        $this->assertEquals( 'Test image title', $image->getTitle( ) );
        $this->assertEquals( 'Earth', $image->getGeoLocation( ) );
        $this->assertEquals( 'http://www.example.com/license.html', $image->getLicense( ) );

        $image->setLocation( 'http://www.example.com/image2.jpg', $image->getLocation( ) );

    }

    public function testCreatingArrayRepresentation( )
    {
        $image =
            ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
                ->setCaption( 'Test image caption' )
                ->setTitle( 'Test image title' )
                ->setGeoLocation( 'Earth' )
                ->setLicense( 'http://www.example.com/license.html' );

        $arr = $image->toArray( );

        $this->assertArrayHasKey( 'location', $arr );
        $this->assertEquals( 'http://www.example.com/image1.jpg', $arr[ 'location' ] );
        $this->assertArrayHasKey( 'location', $arr );
        $this->assertEquals( 'Test image caption', $arr[ 'caption' ] );
        $this->assertArrayHasKey( 'location', $arr );
        $this->assertEquals( 'Test image title', $arr[ 'title' ] );
        $this->assertArrayHasKey( 'location', $arr );
        $this->assertEquals( 'Earth', $arr[ 'geoLocation' ] );
        $this->assertArrayHasKey( 'license', $arr );
        $this->assertEquals( 'http://www.example.com/license.html', $arr[ 'license' ] );

    }

    public function testEncodingAsJson( )
    {
        $image =
            ( new \Lukaswhite\Sitemap\Extensions\Image( 'http://www.example.com/image1.jpg' ) )
                ->setCaption( 'Test image caption' )
                ->setTitle( 'Test image title' )
                ->setGeoLocation( 'Earth' )
                ->setLicense( 'http://www.example.com/license.html' );

        $this->assertEquals( $image->toArray( ), json_decode( json_encode( $image ), true ) );
    }

}
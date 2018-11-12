<?php

class VideoTest extends \PHPUnit\Framework\TestCase
{
    public function testCreatingVideo( )
    {
        $video =
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
            );

        $arr = $video->toArray( );

        $this->assertEquals( 'Grilling steaks for summer', $video->getTitle( ) );
        $this->assertEquals(
            'Alkis shows you how to get perfectly done steaks every time',
            $video->getDescription( )
        );
        $this->assertEquals( 'http://streamserver.example.com/video123.mp4', $video->getContentLocation( ) );
        $this->assertEquals( 600, $video->getDuration( ) );
        $this->assertEquals(
            '2021-11-05 19:20:30',
            $video->getExpirationDate( )->format( 'Y-m-d H:i:s' )
        );
        $this->assertEquals(
            '2007-11-05 19:20:30',
            $video->getPublicationDate( )->format( 'Y-m-d H:i:s' )
        );

        $this->assertInstanceOf( \Lukaswhite\Sitemap\Support\Video\Player::class, $video->getPlayer( ) );
        $this->assertEquals(
            'http://www.example.com/videoplayer.php?video=123',
            $video->getPlayer( )->getLocation( )
        );
        $this->assertNotNull( $video->getPlayer( )->getAllowEmed( ) );
        $this->assertTrue( $video->getPlayer( )->allowsEmbedding( ) );
        $this->assertArrayHasKey( 'location', $video->getPlayer( )->toArray( ) );
        $this->assertEquals(
            'http://www.example.com/videoplayer.php?video=123',
            $video->getPlayer( )->toArray( )[ 'location' ]
        );
        $this->assertArrayHasKey( 'allowEmbed', $video->getPlayer( )->toArray( ) );
        $this->assertEquals(
            true,
            $video->getPlayer( )->toArray( )[ 'allowEmbed' ]
        );

        $this->assertEquals( 4.2, $video->getRating( ) );
        $this->assertEquals( 1.99, $video->getPrice( )->getValue( ) );
        $this->assertEquals( 'EUR', $video->getPrice( )->getCurrency( ) );
        $this->assertEquals( 'own', $video->getPrice( )->getType( ) );
        $this->assertEquals( 'hd', $video->getPrice( )->getResolution( ) );
        $this->assertEquals( [
            'value'  =>  1.99,
            'currency'  =>  'EUR',
            'type' => 'own',
            'resolution' => 'hd',
        ], $video->getPrice( )->toArray( ) );

        $this->assertArrayHasKey( 'price', $arr );
        $this->assertTrue( is_array( $arr[ 'price' ] ) );
        $this->assertEquals( $video->getPrice( )->toArray( ), $arr[ 'price' ] );

        $this->assertInstanceOf(
            \Lukaswhite\Sitemap\Support\Video\Restriction::class,
            $video->getRestriction( )
        );
        $this->assertTrue( is_array( $video->getRestriction( )->getCountries( ) ) );
        $this->assertEquals( 4, count( $video->getRestriction( )->getCountries( ) ) );
        $this->assertEquals( [ 'IE', 'GB', 'US', 'CA' ], $video->getRestriction( )->getCountries( ) );
        $this->assertEquals(
            \Lukaswhite\Sitemap\Support\Video\Restriction::ALLOW,
            $video->getRestriction( )->getRelationship( )
        );
        $this->assertEquals(
            'allow',
            $video->getRestriction( )->getRelationship( )
        );
        $this->assertEquals( [
            'countries' =>  [ 'IE', 'GB', 'US', 'CA' ],
            'relationship' => 'allow'
        ], $video->getRestriction( )->toArray( ) );

        $this->assertArrayHasKey( 'restriction', $arr );
        $this->assertTrue( is_array( $arr[ 'restriction' ] ) );
        $this->assertEquals( $video->getRestriction( )->toArray( ), $arr[ 'restriction' ] );

        $this->assertInstanceOf(
            \Lukaswhite\Sitemap\Support\Video\Platform::class,
            $video->getPlatform( )
        );
        $this->assertTrue( is_array( $video->getPlatform( )->getPlatforms( ) ) );
        $this->assertEquals( [ 'tv', 'web' ], $video->getPlatform( )->getPlatforms( ) );
        $this->assertEquals(
            \Lukaswhite\Sitemap\Support\Video\Platform::DENY,
            $video->getPlatform( )->getRelationship( )
        );
        $this->assertEquals(
            'deny',
            $video->getPlatform( )->getRelationship( )
        );
        $this->assertEquals( [
            'platforms' =>  [ 'tv', 'web' ],
            'relationship' => 'deny'
        ], $video->getPlatform( )->toArray( ) );

        $this->assertArrayHasKey( 'platform', $arr );
        $this->assertTrue( is_array( $arr[ 'platform' ] ) );
        $this->assertEquals( $video->getPlatform( )->toArray( ), $arr[ 'platform' ] );

        $this->assertNotNull( $video->getLive( ) );
        $this->assertTrue( $video->isLive( ) );
        $this->assertNotNull( $video->getFamilyFriendly( ) );
        $this->assertTrue( $video->isFamilyFriendly( ) );
        $this->assertNotNull( $video->getRequiresSubscription( ) );
        $this->assertTrue( $video->requiresSubscription( ) );

        $this->assertEquals(
            [ 'steak', 'grilling', 'summer' ],
            $video->getTags( )
        );

        $this->assertEquals(
            [ 'Cooking', 'Beef' ],
            $video->getCategories( )
        );

        $this->assertInstanceOf( \Lukaswhite\Sitemap\Support\Video\Uploader::class, $video->getUploader( ) );
        $this->assertEquals( 'GrillyMcGrillerson', $video->getUploader( )->getName( ) );
        $this->assertEquals( 'http://www.example.com/users/grillymcgrillerson', $video->getUploader( )->getInfo( ) );
        $this->assertEquals( [
            'name'  =>  'GrillyMcGrillerson',
            'info'  =>  'http://www.example.com/users/grillymcgrillerson',
        ], $video->getUploader( )->toArray( ) );

        $this->assertArrayHasKey( 'uploader', $arr );
        $this->assertTrue( is_array( $arr[ 'uploader' ] ) );
        $this->assertEquals( $video->getUploader( )->toArray( ), $arr[ 'uploader' ] );

        $this->assertEquals( $video->toArray( ), json_decode( json_encode( $video ), true ) );

        $page = new \Lukaswhite\Sitemap\Page( 'http://example.com/video' );
        $page->addVideo( $video );

        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );
        $sitemap->addPage( $page );

        $writer = new \Lukaswhite\Sitemap\Writer\Xml( $sitemap );


        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:title>Grilling steaks for summer</video:title>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:description>Alkis shows you how to get perfectly done steaks every time</video:description>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:content_loc>http://streamserver.example.com/video123.mp4</video:content_loc>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:publication_date>2007-11-05T19:20:30+00:00</video:publication_date>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:expiration_date>2021-11-05T19:20:30+00:00</video:expiration_date>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:player_loc allow_embed="yes">http://www.example.com/videoplayer.php?video=123</video:player_loc>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:restriction relationship="allow">IE GB US CA</video:restriction>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:platform relationship="deny">tv web</video:platform>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:uploader info="http://www.example.com/users/grillymcgrillerson">GrillyMcGrillerson</video:uploader>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:tag>steak</video:tag>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:tag>grilling</video:tag>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:tag>summer</video:tag>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:category>Cooking</video:category>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:category>Beef</video:category>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:duration>600</video:duration>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:rating>4.2</video:rating>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:view_count>1000</video:view_count>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:family_friendly>yes</video:family_friendly>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:requires_subscription>yes</video:requires_subscription>'
            ) > -1
        );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:live>yes</video:live>'
            ) > -1
        );

        $this->assertArrayHasKey( 'videos', $page->toArray( ) );
        $this->assertTrue( is_array( $page->toArray( )[ 'videos' ] ) );
        $this->assertEquals( 1, count( $page->toArray( )[ 'videos' ] ) );
        $this->assertArrayHasKey( 'tags', $page->toArray( )[ 'videos' ][ 0 ] );
        $this->assertTrue( is_array( $page->toArray( )[ 'videos' ][ 0 ][ 'tags' ] ) );
        $this->assertEquals( 3, count( $page->toArray( )[ 'videos' ][ 0 ][ 'tags' ] ) );
    }

    public function testSettingThumbnailLocationInsteadOfContentLocation( )
    {
        $video =
            ( new \Lukaswhite\Sitemap\Extensions\Video(  ) )
                ->setTitle( 'Grilling steaks for summer' )
                ->setDescription( 'Alkis shows you how to get perfectly done steaks every time' )
                ->setThumbnailLocation( 'http://streamserver.example.com/thumbnail123.jpg' );

        $this->assertEquals(
            'http://streamserver.example.com/thumbnail123.jpg',
            $video->getThumbnailLocation( )
        );

        $this->assertArrayHasKey( 'thumbnailLocation', $video->toArray( ) );
        $this->assertEquals(
            'http://streamserver.example.com/thumbnail123.jpg',
            $video->toArray( )[ 'thumbnailLocation' ]
        );

        $page = new \Lukaswhite\Sitemap\Page( 'http://example.com/video' );
        $page->addVideo( $video );

        $sitemap = new \Lukaswhite\Sitemap\Sitemap( );
        $sitemap->addPage( $page );

        $writer = new \Lukaswhite\Sitemap\Writer\Xml( $sitemap );

        $this->assertTrue(
            strpos(
                $writer->write( ),
                '<video:thumbnail_loc>http://streamserver.example.com/thumbnail123.jpg</video:thumbnail_loc>'
            ) > -1
        );
    }

    public function testStaticMethodsForCreatingRestrictions( )
    {
        $allow = \Lukaswhite\Sitemap\Support\Video\Restriction::allowedIn( 'IE', 'GB', 'US', 'CA' );
        $this->assertEquals( ['IE', 'GB', 'US', 'CA' ], $allow->getCountries( ) );
        $this->assertEquals( 'allow', $allow->getRelationship( ) );
        $deny = \Lukaswhite\Sitemap\Support\Video\Restriction::deniedIn( 'IE', 'GB', 'US', 'CA' );
        $this->assertEquals( ['IE', 'GB', 'US', 'CA' ], $deny->getCountries( ) );
        $this->assertEquals( 'deny', $deny->getRelationship( ) );
    }

    public function testStaticMethodsForCreatingPlatforms( )
    {
        $allow = \Lukaswhite\Sitemap\Support\Video\Platform::allowsPlatforms( 'web', 'tv' );
        $this->assertEquals( ['web', 'tv' ], $allow->getPlatforms( ) );
        $this->assertEquals( 'allow', $allow->getRelationship( ) );
        $deny = \Lukaswhite\Sitemap\Support\Video\Platform::deniesPlatforms( 'web', 'tv' );
        $this->assertEquals( ['web', 'tv' ], $deny->getPlatforms( ) );
        $this->assertEquals( 'deny', $deny->getRelationship( ) );

        $webOnly = \Lukaswhite\Sitemap\Support\Video\Platform::onlyAllowsWeb( );
        $this->assertEquals( ['web' ], $webOnly->getPlatforms( ) );
        $this->assertEquals( 'allow', $webOnly->getRelationship( ) );

        $mobileOnly = \Lukaswhite\Sitemap\Support\Video\Platform::onlyAllowsMobile( );
        $this->assertEquals( ['mobile' ], $mobileOnly->getPlatforms( ) );
        $this->assertEquals( 'allow', $mobileOnly->getRelationship( ) );

        $tvOnly = \Lukaswhite\Sitemap\Support\Video\Platform::onlyAllowsTV( );
        $this->assertEquals( [ 'tv' ], $tvOnly->getPlatforms( ) );
        $this->assertEquals( 'allow', $tvOnly->getRelationship( ) );

        $webAndMobileOnly = \Lukaswhite\Sitemap\Support\Video\Platform::onlyAllowsWebAndMobile( );
        $this->assertEquals( [ 'web', 'mobile' ], $webAndMobileOnly->getPlatforms( ) );
        $this->assertEquals( 'allow', $webAndMobileOnly->getRelationship( ) );

        $webAndTVOnly = \Lukaswhite\Sitemap\Support\Video\Platform::onlyAllowsWebAndTV( );
        $this->assertEquals( [ 'web', 'tv' ], $webAndTVOnly->getPlatforms( ) );
        $this->assertEquals( 'allow', $webAndTVOnly->getRelationship( ) );

        $mobileAndTVOnly = \Lukaswhite\Sitemap\Support\Video\Platform::onlyAllowsMobileandTV( );
        $this->assertEquals( [ 'mobile', 'tv' ], $mobileAndTVOnly->getPlatforms( ) );
        $this->assertEquals( 'allow', $mobileAndTVOnly->getRelationship( ) );
    }

}
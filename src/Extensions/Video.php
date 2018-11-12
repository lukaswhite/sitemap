<?php

namespace Lukaswhite\Sitemap\Extensions;
use Lukaswhite\Sitemap\Support\Video\Platform;
use Lukaswhite\Sitemap\Support\Video\Player;
use Lukaswhite\Sitemap\Support\Video\Price;
use Lukaswhite\Sitemap\Support\Video\Restriction;
use Lukaswhite\Sitemap\Support\Video\Uploader;

/**
 * Class Video
 *
 * Represents a video, for use within a sitemap
 *
 * @package Jobyay\Core\Services\Seo\Sitemaps
 */
class Video implements \JsonSerializable
{
    /**
     * The title of the video
     *
     * @var string
     */
    protected $title;

    /**
     * The location of the video
     *
     * @var string
     */
    protected $description;

    /**
     * The location of the video content
     *
     * @var string
     */
    protected $contentLocation;

    /**
     * The location of the video thumbnail
     *
     * @var string
     */
    protected $thumbnailLocation;

    /**
     * The player, if applicable
     *
     * @var Player
     */
    protected $player;

    /**
     * The duration of the video, in seconds
     *
     * @var string
     */
    protected $duration;

    /**
     * The publication date
     *
     * @var \DateTime
     */
    protected $publicationDate;

    /**
     * The expiration date of the video, if applicable
     *
     * @var \DateTime
     */
    protected $expirationDate;

    /**
     * A rating for the video
     *
     * @var float
     */
    protected $rating;

    /**
     * The view count
     *
     * @var integer
     */
    protected $viewCount;

    /**
     * Whether the video is family friendly
     *
     * @var bool
     */
    protected $familyFriendly;

    /**
     * Whether the video requires a subscription
     *
     * @var bool
     */
    protected $requiresSubscription;

    /**
     * Whether the video is live
     *
     * @var bool
     */
    protected $live;

    /**
     * The uploader
     *
     * @var Uploader
     */
    protected $uploader;

    /**
     * The price
     *
     * @var Price
     */
    protected $price;

    /**
     * The restriction
     *
     * @var Restriction
     */
    protected $restriction;

    /**
     * The platform
     *
     * @var Platform
     */
    protected $platform;

    /**
     * Tags that describe the video
     *
     * @var array
     */
    protected $tags = [ ];

    /**
     * Categories that describe the video
     *
     * @var array
     */
    protected $categories = [ ];

    /**
     * Video constructor.
     *
     */
    public function __construct(  )
    {

    }

    /**
     * Create an array representation of this image
     *
     * @return array
     */
    public function toArray( ) : array
    {
        $data = [
            'title'                 =>  $this->title,
            'description'           =>  $this->description,
        ];

        if ( $this->duration ) {
            $data[ 'duration' ] = $this->duration;
        }

        if ( $this->publicationDate ) {
            $data[ 'publicationDate' ] = $this->publicationDate->format( DATE_W3C );
        }

        if ( $this->expirationDate ) {
            $data[ 'expirationDate' ] = $this->expirationDate->format( DATE_W3C );
        }

        if ( $this->getLive() ) {
            $data[ 'live' ] = $this->isLive( );
        }

        if ( $this->getFamilyFriendly() ) {
            $data[ 'familyFriendly' ] = $this->isFamilyFriendly( );
        }

        if ( $this->getRequiresSubscription() ) {
            $data[ 'requiresSubscription' ] = $this->requiresSubscription( );
        }

        if ( $this->contentLocation ) {
            $data[ 'contentLocation' ] = $this->contentLocation;
        } elseif ( $this->thumbnailLocation ) {
            $data[ 'thumbnailLocation' ] = $this->thumbnailLocation;
        }

        if ( $this->player ) {
            $data[ 'player' ] = $this->player->toArray( );
        }

        if ( $this->price ) {
            $data[ 'price' ] = $this->price->toArray( );
        }

        if ( $this->restriction ) {
            $data[ 'restriction' ] = $this->restriction->toArray( );
        }

        if ( $this->platform ) {
            $data[ 'platform' ] = $this->platform->toArray( );
        }

        if ( $this->uploader ) {
            $data[ 'uploader' ] = $this->uploader->toArray( );
        }

        if ( count( $this->tags ) ) {
            $data[ 'tags' ] = $this->tags;
        }

        if ( count( $this->categories ) ) {
            $data[ 'categories' ] = $this->categories;
        }

        return $data;
    }

    /**
     * Specifies the data that should be used to create a JSON representation
     * of this image.
     *
     * @return array
     */
    public function jsonSerialize( )
    {
        return $this->toArray( );
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentLocation()
    {
        return $this->contentLocation;
    }

    /**
     * @param string $contentLocation
     * @return Video
     */
    public function setContentLocation($contentLocation)
    {
        $this->contentLocation = $contentLocation;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnailLocation( ) : string
    {
        return $this->thumbnailLocation;
    }

    /**
     * @param string $thumbnailLocation
     * @return Video
     */
    public function setThumbnailLocation( string $thumbnailLocation ) : self
    {
        $this->thumbnailLocation = $thumbnailLocation;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer( ) : ?Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return Video
     */
    public function setPlayer( Player $player ) : self
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     * @return Video
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime $publicationDate
     * @return Video
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     * @return Video
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     * @return Video
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return int
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     * @return Video
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    /**
     * Get the family friendly value. Note that this isn't a yes / no, because the
     * value may not have been set, in which case it won't be included.
     *
     * @return bool
     */
    public function getFamilyFriendly()
    {
        return $this->familyFriendly;
    }

    /**
     * Determine whether this video is family friendly.
     *
     * @return bool
     */
    public function isFamilyFriendly()
    {
        return !! $this->familyFriendly;
    }

    /**
     * @param bool $familyFriendly
     * @return Video
     */
    public function setFamilyFriendly( $familyFriendly = true ) : self
    {
        $this->familyFriendly = $familyFriendly;
        return $this;
    }

    /**
     * Get the value for requires subscription; Note that this isn't a yes / no, because the
     * value may not have been set, in which case it won't be included.
     *
     * @return bool
     */
    public function getRequiresSubscription( ) : ?bool
    {
        return $this->requiresSubscription;
    }

    /**
     * Whether this video requires subscription
     * @return bool
     */
    public function requiresSubscription()
    {
        return !! $this->requiresSubscription;
    }

    /**
     * @param bool $requiresSubscription
     * @return Video
     */
    public function setRequiresSubscription( $requiresSubscription = true )
    {
        $this->requiresSubscription = $requiresSubscription;
        return $this;
    }

    /**
     * Get the live value; note that this isn't a simple yes/no as it's an optional value, so
     * not having been set isn't the same as false, despite the fact that it's false by default.
     *
     * @return bool
     */
    public function getLive()
    {
        return $this->live;
    }

    /**
     * @return bool
     */
    public function isLive()
    {
        return !! $this->live;
    }

    /**
     * @param bool $live
     * @return Video
     */
    public function setLive( $live = true )
    {
        $this->live = $live;
        return $this;
    }

    /**
     * @return Uploader
     */
    public function getUploader()
    {
        return $this->uploader;
    }

    /**
     * @param Uploader $uploader
     * @return Video
     */
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;
        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     * @return Video
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get the restriction, if applicable
     *
     * @return array
     */
    public function getRestriction( ) : ?Restriction
    {
        return $this->restriction;
    }

    /**
     * Add a restriction
     *
     * @param Restriction $restriction
     * @return Video
     */
    public function addRestriction( Restriction $restriction )
    {
        $this->restriction = $restriction;
        return $this;
    }

    /**
     * @return Platform
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param Platform $platform
     * @return Video
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return Video
     */
    public function setTags( ...$tags ) : self
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     * @return Video
     */
    public function setCategories( ...$categories ) : self
    {
        $this->categories = $categories;
        return $this;
    }



}
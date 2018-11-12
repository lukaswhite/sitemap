<?php

namespace Lukaswhite\Sitemap\Support;

trait Restricts {

    /**
     * The relationship; allow or deny
     *
     * @var string
     */
    protected $relationship;

    /**
     * @return string
     */
    public function getRelationship( ) : string
    {
        return $this->relationship;
    }

    /**
     * @param string $relationship
     * @return self
     */
    public function setRelationship( string $relationship ) : self
    {
        $this->relationship = $relationship;
        return $this;
    }

    /**
     * Indicate that this is an "allow" restriction
     *
     * @return self
     */
    public function allows( )
    {
        return $this->setRelationship( self::ALLOW );
    }

    /**
     * Indicate that this is a "deny" restriction
     *
     * @return self
     */
    public function denies( )
    {
        return $this->setRelationship( self::DENY );
    }


}
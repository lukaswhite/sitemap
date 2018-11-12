<?php

namespace Lukaswhite\Sitemap\Support\Video;

/**
 * Class Price
 * 
 * @package Lukaswhite\Sitemap\Support\Video
 */
class Price
{
    /**
     * Class constants
     */
    const RENT      =   'rent';
    const OWN       =   'own';

    const HD        =   'hd';
    const SD        =   'sd';

    /**
     * The actual value
     *
     * @var float
     */
    protected $value;

    /**
     * The currency
     *
     * @var string
     */
    protected $currency;

    /**
     * The type (rent / own)
     *
     * @var string
     */
    protected $type;

    /**
     * The resolution (hd / sd)
     *
     * @var string
     */
    protected $resolution;

    /**
     * Price constructor.
     *
     * @param float $value
     * @param string $currency
     * @param string|null $type
     * @param string|null $resolution
     */
    public function __construct( float $value, string $currency, string $type = null, string $resolution = null )
    {
        $this->setValue( $value );
        $this->setCurrency( $currency );
        $this->setType( $type );
        $this->setResolution( $resolution );
    }

    /**
     * Get the actual price
     *
     * @return float
     */
    public function getValue( ) : float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Price
     */
    public function setValue( float $value ) : self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency( ) : string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Price
     */
    public function setCurrency( string $currency ): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getType( ) : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Price
     */
    public function setType( ?string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getResolution( ) : string
    {
        return $this->resolution;
    }

    /**
     * @param string $resolution
     * @return Price
     */
    public function setResolution( ?string $resolution ) : self
    {
        $this->resolution = $resolution;
        return $this;
    }

    /**
     * Create an array representation of this price
     *
     * @return array
     */
    public function toArray( ) : array
    {
        $data = [
            'value'         =>  $this->value,
            'currency'      =>  $this->currency,
        ];

        if ( isset( $this->type ) ) {
            $data[ 'type' ] = $this->type;
        }

        if ( isset( $this->resolution ) ) {
            $data[ 'resolution' ] = $this->resolution;
        }

        return $data;
    }

}
<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Overview
 */
class Overview
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\Image(
     * maxSize = "7500k"
     * )
     */
    private $largeImage;

    /**
     * @var text
     */
    private $overview;

    /**
     * @var text
     */
    private $mainAddress;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $latitude;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set largeImage
     *
     * @param string $largeImage
     *
     * @return Overview
     */
    public function setLargeImage($largeImage)
    {
        $this->largeImage = $largeImage;

        return $this;
    }

    /**
     * Get largeImage
     *
     * @return string
     */
    public function getLargeImage()
    {
        return $this->largeImage;
    }

    /**
     * Set overview
     *
     * @param \DateTime $overview
     *
     * @return Overview
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return \DateTime
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Set mainAddress
     *
     * @param \DateTime $overview
     *
     * @return Overview
     */
    public function setMainAddress($mainAddress)
    {
        $this->mainAddress = $mainAddress;

        return $this;
    }

    /**
     * Get overview
     *
     * @return \DateTime
     */
    public function getMainAddress()
    {
        return $this->mainAddress;
    }

    /**
     * Set longitude
     *
     * @param \DateTime $overview
     *
     * @return Overview
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return \DateTime
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param \DateTime $overview
     *
     * @return Overview
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return \DateTime
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}

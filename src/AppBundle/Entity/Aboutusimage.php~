<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Aboutusimage
 */
class Aboutusimage
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
     * @var \DateTime
     */
    private $createdAt;

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
     * @return Aboutusimage
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Aboutusimage
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * @var \AppBundle\Entity\Aboutus
     */
    private $aboutus;


    /**
     * Set aboutus
     *
     * @param \AppBundle\Entity\Aboutus $aboutus
     *
     * @return Aboutusimage
     */
    public function setAboutus(\AppBundle\Entity\Aboutus $aboutus = null)
    {
        $this->aboutus = $aboutus;

        return $this;
    }

    /**
     * Get aboutus
     *
     * @return \AppBundle\Entity\Aboutus
     */
    public function getAboutus()
    {
        return $this->aboutus;
    }
}

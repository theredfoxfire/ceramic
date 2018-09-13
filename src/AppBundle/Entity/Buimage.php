<?php

namespace AppBundle\Entity;

/**
 * Buimage
 */
class Buimage
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
     * @var string
     */
    private $largeImage;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \AppBundle\Entity\Unites
     */
    private $unites;


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
     * @return Buimage
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
     * @return Buimage
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
     * Set unites
     *
     * @param \AppBundle\Entity\Unites $unites
     *
     * @return Buimage
     */
    public function setUnites(\AppBundle\Entity\Unites $unites = null)
    {
        $this->unites = $unites;

        return $this;
    }

    /**
     * Get unites
     *
     * @return \AppBundle\Entity\Unites
     */
    public function getUnites()
    {
        return $this->unites;
    }
}

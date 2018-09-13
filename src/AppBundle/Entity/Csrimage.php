<?php

namespace AppBundle\Entity;

/**
 * Csrimage
 */
class Csrimage
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
     * @var \AppBundle\Entity\Csr
     */
    private $csr;


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
     * @return Csrimage
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
     * @return Csrimage
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
     * Set csr
     *
     * @param \AppBundle\Entity\Csr $csr
     *
     * @return Csrimage
     */
    public function setCsr(\AppBundle\Entity\Csr $csr = null)
    {
        $this->csr = $csr;

        return $this;
    }

    /**
     * Get csr
     *
     * @return \AppBundle\Entity\Csr
     */
    public function getCsr()
    {
        return $this->csr;
    }
}

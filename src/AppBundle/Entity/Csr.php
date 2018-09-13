<?php

namespace AppBundle\Entity;

/**
 * Csr
 */
class Csr
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $story;

    /**
     * @var string
     */
    private $largeImage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $csr_image;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->csr_image = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Csr
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set story
     *
     * @param string $story
     *
     * @return Csr
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set largeImage
     *
     * @param string $largeImage
     *
     * @return Csr
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
     * Add csrImage
     *
     * @param \AppBundle\Entity\Csrimage $csrImage
     *
     * @return Csr
     */
    public function addCsrImage(\AppBundle\Entity\Csrimage $csrImage)
    {
        $this->csr_image[] = $csrImage;

        return $this;
    }

    /**
     * Remove csrImage
     *
     * @param \AppBundle\Entity\Csrimage $csrImage
     */
    public function removeCsrImage(\AppBundle\Entity\Csrimage $csrImage)
    {
        $this->csr_image->removeElement($csrImage);
    }

    /**
     * Get csrImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCsrImage()
    {
        return $this->csr_image;
    }
}

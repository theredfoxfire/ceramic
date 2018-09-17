<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Aboutus
 */
class Aboutus
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $preword;

    /**
     * @var string
     */
    private $story;

    /**
     * @var string
     * @Assert\Image(
     * maxSize = "7500k"
     * )
     *
     */
    private $largeImage;

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
     * Set preword
     *
     * @param string $preword
     *
     * @return Aboutus
     */
    public function setPreword($preword)
    {
        $this->preword = $preword;

        return $this;
    }

    /**
     * Get preword
     *
     * @return string
     */
    public function getPreword()
    {
        return $this->preword;
    }

    /**
     * Set story
     *
     * @param string $story
     *
     * @return Aboutus
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
     * @return Unites
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $aboutus_image;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aboutus_image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add aboutusImage
     *
     * @param \AppBundle\Entity\Aboutusimage $aboutusImage
     *
     * @return Aboutus
     */
    public function addAboutusImage(\AppBundle\Entity\Aboutusimage $aboutusImage)
    {
        $this->aboutus_image[] = $aboutusImage;

        return $this;
    }

    /**
     * Remove aboutusImage
     *
     * @param \AppBundle\Entity\Aboutusimage $aboutusImage
     */
    public function removeAboutusImage(\AppBundle\Entity\Aboutusimage $aboutusImage)
    {
        $this->aboutus_image->removeElement($aboutusImage);
    }

    /**
     * Get aboutusImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAboutusImage()
    {
        return $this->aboutus_image;
    }
}

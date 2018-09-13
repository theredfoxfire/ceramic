<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Unites
 */
class Unites
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
     * Set title
     *
     * @param string $title
     *
     * @return Unites
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
     * @return Unites
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
    private $unites_image;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unites_image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add unitesImage
     *
     * @param \AppBundle\Entity\Buimage $unitesImage
     *
     * @return Unites
     */
    public function addUnitesImage(\AppBundle\Entity\Buimage $unitesImage)
    {
        $this->unites_image[] = $unitesImage;

        return $this;
    }

    /**
     * Remove unitesImage
     *
     * @param \AppBundle\Entity\Buimage $unitesImage
     */
    public function removeUnitesImage(\AppBundle\Entity\Buimage $unitesImage)
    {
        $this->unites_image->removeElement($unitesImage);
    }

    /**
     * Get unitesImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnitesImage()
    {
        return $this->unites_image;
    }
    /**
     * @var \AppBundle\Entity\Category
     */
    private $category;


    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Unites
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var string
     */
    private $subtitle;


    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Unites
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }
    /**
     * @var string
     */
    private $webUrl;


    /**
     * Set webUrl
     *
     * @param string $webUrl
     *
     * @return Unites
     */
    public function setWebUrl($webUrl)
    {
        $this->webUrl = $webUrl;

        return $this;
    }

    /**
     * Get webUrl
     *
     * @return string
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }
}

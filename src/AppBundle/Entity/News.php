<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 */
class News
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
    private $subtitle;

    /**
     * @var string
     */
    private $story;

    /**
    * @var string
    * @Assert\Image(
    * maxSize = "2024k"
    * )
     */
    private $largeImage;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $postedBy;


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
     * @return News
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
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return News
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
     * Set story
     *
     * @param string $story
     *
     * @return News
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
     * @return News
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
     * Set dateTime
     *
     * @param \DateTime $dateTime
     *
     * @return News
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set by
     *
     * @param string $by
     *
     * @return News
     */
    public function setPostedBy($postedBy)
    {
        $this->postedBy = $postedBy;

        return $this;
    }

    /**
     * Get by
     *
     * @return string
     */
    public function getPostedBy()
    {
        return $this->postedBy;
    }
    /**
     * @var \AppBundle\Entity\Monthnews
     */
    private $monthnews;


    /**
     * Set monthnews
     *
     * @param \AppBundle\Entity\Monthnews $monthnews
     *
     * @return News
     */
    public function setMonthnews(\AppBundle\Entity\Monthnews $monthnews = null)
    {
        $this->monthnews = $monthnews;

        return $this;
    }

    /**
     * Get monthnews
     *
     * @return \AppBundle\Entity\Monthnews
     */
    public function getMonthnews()
    {
        return $this->monthnews;
    }
}

<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Download
 */
class Download
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
    private $overview;

    /**
     * @var string
     * @Assert\File(
     *  maxSize = "4024k"
     *)
     */
    private $file;

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
     * @return Download
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
     * Set overview
     *
     * @param string $overview
     *
     * @return Download
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Download
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     *
     * @return Download
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
     * @return Download
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
     * @var \AppBundle\Entity\Year
     */
    private $year;


    /**
     * Set year
     *
     * @param \AppBundle\Entity\Year $year
     *
     * @return Download
     */
    public function setYear(\AppBundle\Entity\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \AppBundle\Entity\Year
     */
    public function getYear()
    {
        return $this->year;
    }
    /**
     * @var \AppBundle\Entity\Month
     */
    private $month;


    /**
     * Set month
     *
     * @param \AppBundle\Entity\Month $month
     *
     * @return Download
     */
    public function setMonth(\AppBundle\Entity\Month $month = null)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return \AppBundle\Entity\Month
     */
    public function getMonth()
    {
        return $this->month;
    }
}

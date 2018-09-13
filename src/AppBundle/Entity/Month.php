<?php

namespace AppBundle\Entity;

/**
 * Month
 */
class Month
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $month;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $download;

    /**
     * @var \AppBundle\Entity\Year
     */
    private $year;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->download = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set month
     *
     * @param string $month
     *
     * @return Month
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Add download
     *
     * @param \AppBundle\Entity\Download $download
     *
     * @return Month
     */
    public function addDownload(\AppBundle\Entity\Download $download)
    {
        $this->download[] = $download;

        return $this;
    }

    /**
     * Remove download
     *
     * @param \AppBundle\Entity\Download $download
     */
    public function removeDownload(\AppBundle\Entity\Download $download)
    {
        $this->download->removeElement($download);
    }

    /**
     * Get download
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * Set year
     *
     * @param \AppBundle\Entity\Year $year
     *
     * @return Month
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
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Month
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

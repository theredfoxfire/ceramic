<?php

namespace AppBundle\Entity;

/**
 * Year
 */
class Year
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $year;


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
     * Set year
     *
     * @param  $year
     *
     * @return Year
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return
     */
    public function getYear()
    {
        return $this->year;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $month;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->month = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add month
     *
     * @param \AppBundle\Entity\Month $month
     *
     * @return Year
     */
    public function addMonth(\AppBundle\Entity\Month $month)
    {
        $this->month[] = $month;

        return $this;
    }

    /**
     * Remove month
     *
     * @param \AppBundle\Entity\Month $month
     */
    public function removeMonth(\AppBundle\Entity\Month $month)
    {
        $this->month->removeElement($month);
    }

    /**
     * Get month
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonth()
    {
        return $this->month;
    }
}

<?php

namespace AppBundle\Entity;

/**
 * Yearnews
 */
class Yearnews
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $monthnews;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->monthnews = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set year
     *
     * @param string $year
     *
     * @return Yearnews
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Add monthnews
     *
     * @param \AppBundle\Entity\Monthnews $monthnews
     *
     * @return Yearnews
     */
    public function addMonthnews(\AppBundle\Entity\Monthnews $monthnews)
    {
        $this->monthnews[] = $monthnews;

        return $this;
    }

    /**
     * Remove monthnews
     *
     * @param \AppBundle\Entity\Monthnews $monthnews
     */
    public function removeMonthnews(\AppBundle\Entity\Monthnews $monthnews)
    {
        $this->monthnews->removeElement($monthnews);
    }

    /**
     * Get monthnews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonthnews()
    {
        return $this->monthnews;
    }
}


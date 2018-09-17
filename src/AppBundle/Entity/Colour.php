<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Colour
 */
class Colour
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $colour;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $unites;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unites = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set colour
     *
     * @param string $colour
     * @return Colour
     */
    public function setColour($colour)
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * Get colour
     *
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Add unites
     *
     * @param \AppBundle\Entity\Unites $unites
     * @return Colour
     */
    public function addUnite(\AppBundle\Entity\Unites $unites)
    {
        $this->unites[] = $unites;

        return $this;
    }

    /**
     * Remove unites
     *
     * @param \AppBundle\Entity\Unites $unites
     */
    public function removeUnite(\AppBundle\Entity\Unites $unites)
    {
        $this->unites->removeElement($unites);
    }

    /**
     * Get unites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnites()
    {
        return $this->unites;
    }

    /**
    * convert to string to make it available in select options
    */
    public function __toString() {
        return $this->colour;
    }
}

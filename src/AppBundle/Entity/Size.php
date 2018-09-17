<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Size
 */
class Size
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $size;

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
     * Set size
     *
     * @param string $size
     * @return Size
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Add unites
     *
     * @param \AppBundle\Entity\Unites $unites
     * @return Size
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
        return $this->size;
    }
}

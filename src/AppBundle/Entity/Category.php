<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $category;


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
     * Set category
     *
     * @param string $category
     *
     * @return Category
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
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
     * Add unite
     *
     * @param \AppBundle\Entity\Unites $unite
     *
     * @return Category
     */
    public function addUnite(\AppBundle\Entity\Unites $unite)
    {
        $this->unites[] = $unite;

        return $this;
    }

    /**
     * Remove unite
     *
     * @param \AppBundle\Entity\Unites $unite
     */
    public function removeUnite(\AppBundle\Entity\Unites $unite)
    {
        $this->unites->removeElement($unite);
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
        return $this->category;
    }
}

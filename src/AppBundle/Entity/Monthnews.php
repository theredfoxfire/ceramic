<?php

namespace AppBundle\Entity;

/**
 * Monthnews
 */
class Monthnews
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $month;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $news;

    /**
     * @var \AppBundle\Entity\Yearnews
     */
    private $yearnews;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set month
     *
     * @param string $month
     *
     * @return Monthnews
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
     * Set name
     *
     * @param string $name
     *
     * @return Monthnews
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

    /**
     * Add news
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return Monthnews
     */
    public function addNews(\AppBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \AppBundle\Entity\News $news
     */
    public function removeNews(\AppBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set yearnews
     *
     * @param \AppBundle\Entity\Yearnews $yearnews
     *
     * @return Monthnews
     */
    public function setYearnews(\AppBundle\Entity\Yearnews $yearnews = null)
    {
        $this->yearnews = $yearnews;

        return $this;
    }

    /**
     * Get yearnews
     *
     * @return \AppBundle\Entity\Yearnews
     */
    public function getYearnews()
    {
        return $this->yearnews;
    }
}

<?php

namespace Spleen\JobeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Spleen\JobeetBundle\Utils\Jobeet;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Spleen\JobeetBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Job", mappedBy="category")
     */
    private $jobs;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Affiliate", mappedBy="categories")
     */
    private $affiliates;
    
    /**
     * @var ArrayCollection
     * 
     */
    private $active_jobs;
    
    private $more_jobs;

    
    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->affiliates = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Category
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
     * Add jobs
     *
     * @param \Spleen\JobeetBundle\Entity\Job $jobs
     * @return Category
     */
    public function addJob(\Spleen\JobeetBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Spleen\JobeetBundle\Entity\Job $jobs
     */
    public function removeJob(\Spleen\JobeetBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add affiliates
     *
     * @param \Spleen\JobeetBundle\Entity\Affiliate $affiliates
     * @return Category
     */
    public function addAffiliate(\Spleen\JobeetBundle\Entity\Affiliate $affiliates)
    {
        $this->affiliates[] = $affiliates;

        return $this;
    }

    /**
     * Remove affiliates
     *
     * @param \Spleen\JobeetBundle\Entity\Affiliate $affiliates
     */
    public function removeAffiliate(\Spleen\JobeetBundle\Entity\Affiliate $affiliates)
    {
        $this->affiliates->removeElement($affiliates);
    }

    /**
     * Get affiliates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffiliates()
    {
        return $this->affiliates;
    }
    
    public function __toString()
    {
        return $this->getName() ? $this->getName() : "";
    }
    
    public function setActiveJobs($jobs)
    {
        $this->active_jobs = $jobs;
    }
    
    public function getActiveJobs()
    {
        return $this->active_jobs;
    }
    
    public function getSlug()
    {
        return Jobeet::slugify($this->getName());
    }
    
    public function setMoreJobs($jobs)
    {
        $this->more_jobs= $jobs >= 0 ? $jobs : 0;
    }
    
    public function getMoreJobs()
    {
        return $this->more_jobs;
    }
}

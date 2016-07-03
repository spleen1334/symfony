<?php

namespace Spleen\MagazineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Doctrine\Common\Collections;

/**
 * Publication
 *
 * @ORM\Table(name="publications")
 * @ORM\Entity(repositoryClass="Spleen\MagazineBundle\Entity\PublicationRepository")
 */
class Publication
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="publication")
     */
    private $issues;
    
    
    /**
     * Constructor for $issues (ArrayCollection)
     */
    public function __construct()
    {
        $this->issues = new ArrayCollection();
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
     * @return Publication
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
     * Add issues
     *
     * @param \Spleen\MagazineBundle\Entity\Issue $issues
     * @return Publication
     */
    public function addIssue(\Spleen\MagazineBundle\Entity\Issue $issues)
    {
        $this->issues[] = $issues;

        return $this;
    }

    /**
     * Remove issues
     *
     * @param \Spleen\MagazineBundle\Entity\Issue $issues
     */
    public function removeIssue(\Spleen\MagazineBundle\Entity\Issue $issues)
    {
        $this->issues->removeElement($issues);
    }

    /**
     * Get issues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIssues()
    {
        return $this->issues;
    }
    
    /**
     * Render a publication as a string (override)
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}

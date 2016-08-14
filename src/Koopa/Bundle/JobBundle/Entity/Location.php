<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Location
 *
 * @ORM\Table(name="job_locations")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\LocationRepository")
 */
class Location
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
     * @ORM\Column(name="country", type="string", length=120)
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", unique=true, length=255)
     * @Gedmo\Slug(fields={"town"})
     */
    private $slug;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Job
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Job",
     * mappedBy="locations"
     * )
     */
    private $jobs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new ArrayCollection();
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
     * Set country
     *
     * @param string $country
     * @return Location
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return Location
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Location
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add jobs
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Job $jobs
     * @return Location
     */
    public function addJob(\Koopa\Bundle\JobBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;
        $jobs->addLocation($this);

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Job $jobs
     */
    public function removeJob(\Koopa\Bundle\JobBundle\Entity\Job $jobs)
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
}

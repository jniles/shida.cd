<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SubCategory
 *
 * @ORM\Table(name="job_sub_categories")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\SubCategoryRepository")
 */
class SubCategory
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
     * @ORM\Column(name="name", type="string", length=150)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", unique=true, length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Category
     *
     * @ORM\ManyToOne(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Category",
     * inversedBy="subCategories"
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Job
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Job",
     * mappedBy="subCategories"
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
     * Set name
     *
     * @param string $name
     * @return SubCategory
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
     * Set slug
     *
     * @param string $slug
     * @return SubCategory
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
     * Set category
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Category $category
     * @return SubCategory
     */
    public function setCategory(\Koopa\Bundle\JobBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Koopa\Bundle\JobBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add jobs
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Job $jobs
     * @return SubCategory
     */
    public function addJob(\Koopa\Bundle\JobBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

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

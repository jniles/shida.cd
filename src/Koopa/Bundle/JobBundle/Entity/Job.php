<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Job
 *
 * @ORM\Table(name="job_jobs")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\JobRepository")
 * @ORM\EntityListeners({"Koopa\Bundle\JobBundle\EntityListener\JobListener"})
 */
class Job
{
    const DEFAULT_LIMIT = 5;
    const ITEMS_LIMIT = 15;
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
     * @ORM\Column(name="title", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", unique=true, length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     * @Assert\NotBlank()
     */
    private $summary;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_left", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $timeLeft;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $startAt;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $paymentMethod;

    /**
     * @var float
     *
     * @ORM\Column(name="salary", type="float")
     * @Assert\Regex("/^[0-9\.]+$/")
     */
    private $salary;

    /**
     * @var integer
     *
     * @ORM\Column(name="experience", type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $experience;

    /**
     * @var Koopa\Bundle\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(
     * targetEntity="Koopa\Bundle\UserBundle\Entity\User",
     * inversedBy="jobs"
     * )
     * @ORM\JoinColumn(
     * nullable=false,
     * name="user_id"
     * )
     */
    private $user;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Skill
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Skill",
     * inversedBy="jobs"
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $skills;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Location
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Location",
     * inversedBy="jobs"
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $locations;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\SubCategory
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\SubCategory",
     * inversedBy="jobs"
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $subCategories;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Subscription
     *
     * @ORM\OneToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Subscription",
     * mappedBy="job",
     * cascade={"remove"}
     * )
     */
    private $subscriptions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills        = new ArrayCollection();
        $this->locations     = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->experience    = 0;
        $this->createdAt     = new \DateTime();
        $this->timeLeft      = new \DateTime();
        $this->startAt       = new \DateTime();
        $this->salary        = 0;
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
     * Set title
     *
     * @param string $title
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Job
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Job
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set timeLeft
     *
     * @param \DateTime $timeLeft
     * @return Job
     */
    public function setTimeLeft($timeLeft)
    {
        $this->timeLeft = $timeLeft;

        return $this;
    }

    /**
     * Get timeLeft
     *
     * @return \DateTime
     */
    public function getTimeLeft()
    {
        return $this->timeLeft;
    }

    /**
     * Set startAt
     *
     * @param \DateTime $startAt
     * @return Job
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     * @return Job
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Job
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
     * Set mode
     *
     * @param string $mode
     * @return Job
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set salary
     *
     * @param float $salary
     * @return Job
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Job
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set user
     *
     * @param \Koopa\Bundle\UserBundle\Entity\User $user
     * @return Job
     */
    public function setUser(\Koopa\Bundle\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Koopa\Bundle\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add skills
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Skill $skills
     * @return Job
     */
    public function addSkill(\Koopa\Bundle\JobBundle\Entity\Skill $skills)
    {
        $this->skills[] = $skills;

        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Skill $skills
     */
    public function removeSkill(\Koopa\Bundle\JobBundle\Entity\Skill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Add locations
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Location $locations
     * @return Job
     */
    public function addLocation(\Koopa\Bundle\JobBundle\Entity\Location $locations)
    {
        $this->locations[] = $locations;

        return $this;
    }

    /**
     * Remove locations
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Location $locations
     */
    public function removeLocation(\Koopa\Bundle\JobBundle\Entity\Location $locations)
    {
        $this->locations->removeElement($locations);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Add subCategories
     *
     * @param \Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories
     * @return Job
     */
    public function addSubCategory(\Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;

        return $this;
    }

    /**
     * Remove subCategories
     *
     * @param \Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories
     */
    public function removeSubCategory(\Koopa\Bundle\JobBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories->removeElement($subCategories);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * Add subscriptions
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Subscription $subscriptions
     * @return Job
     */
    public function addSubscription(\Koopa\Bundle\JobBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;
        $subscriptions->setJob($this);

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Subscription $subscriptions
     */
    public function removeSubscription(\Koopa\Bundle\JobBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions->removeElement($subscriptions);
    }

    /**
     * Get subscriptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Job
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    public function convert()
    {
        $data = [];
        $data['title'] = $this->title;
        $data['slug'] = $this->slug;
        $data['createdAt'] = $this->createdAt;
        $data['summary'] = $this->summary;
        $data['paymentMethod'] = $this->paymentMethod;
        $data['salary'] = $this->salary;
        $data['experience'] = $this->experience;

        return $data;
    }

    public function __toString()
    {
        return sprintf(
            'Offre %s %s',
            $this->title,
            $this->summary
        );
    }

    public function url()
    {
        return sprintf('jobs/%s', $this->slug);
    }
}

<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Skill
 *
 * @ORM\Table(name="job_skills")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\SkillRepository")
 * @ORM\EntityListeners({"Koopa\Bundle\JobBundle\EntityListener\SkillListener"})
 */
class Skill
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
     * @var Koopa\Bundle\JobBundle\Entity\Job
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Job",
     * mappedBy="skills"
     * )
     */
    private $jobs;

    /**
     * @var Koopa\Bundle\UserBundle\Entity\User
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\UserBundle\Entity\User",
     * inversedBy="skills"
     * )
     */
    private $users;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs  = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Skill
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
     * @return Skill
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
     * @return Skill
     */
    public function addJob(\Koopa\Bundle\JobBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;
        $jobs->addSkill($this);

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

    /**
     * Add users
     *
     * @param \Koopa\Bundle\UserBundle\Entity\User $users
     * @return Skill
     */
    public function addUser(\Koopa\Bundle\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
        $users->addSkill($this);

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Koopa\Bundle\UserBundle\Entity\User $users
     */
    public function removeUser(\Koopa\Bundle\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}

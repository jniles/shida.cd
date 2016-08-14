<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="job_subscriptions")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\SubscriptionRepository")
 */
class Subscription
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="accept", type="boolean")
     */
    private $accept = false;

    /**
     * @var Koopa\Bundle\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(
     * targetEntity="Koopa\Bundle\UserBundle\Entity\User",
     * inversedBy="subscriptions"
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @var Koopa\Bundle\JobBundle\Entity\Job
     *
     * @ORM\ManyToOne(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Job",
     * inversedBy="subscriptions"
     * )
     */
    private $job;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Subscription
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
     * Set job
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Job $job
     * @return Subscription
     */
    public function setJob(\Koopa\Bundle\JobBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Koopa\Bundle\JobBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set user
     *
     * @param \Koopa\Bundle\UserBundle\Entity\User $user
     * @return Subscription
     */
    public function setUser(\Koopa\Bundle\UserBundle\Entity\User $user = null)
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
     * Set accept
     *
     * @param boolean $accept
     * @return Subscription
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Get accept
     *
     * @return boolean
     */
    public function getAccept()
    {
        return $this->accept;
    }
}

<?php

namespace Koopa\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Koopa\Bundle\AppBundle\Entity\Image;
use Koopa\Bundle\JobBundle\Entity\Job;
use Koopa\Bundle\JobBundle\Entity\Skill;
use Koopa\Bundle\JobBundle\Entity\Subscription;

/**
 * User
 *
 * @ORM\Table("koopa_users")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    const ROLE_ADVERTISER = 'role_advertiser';
    const ROLE_APPLICANT  = 'role_applicant';
    const ROLE_IMMO       = 'role_immo';
    const ROLE_ALL       = 'role_all';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Image
     *
     * @ORM\OneToOne(
     * targetEntity="Koopa\Bundle\AppBundle\Entity\Image",
     * cascade={"persist", "remove"},
     * )
     */
    private $image;

    /**
     * @var sting
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="fistname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var Job
     *
     * @ORM\OneToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Job",
     * mappedBy="user",
     * cascade={"remove"}
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $jobs;

    /**
     * @var Skill
     *
     * @ORM\ManyToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Skill",
     * inversedBy="users"
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $skills;

    /**
     * @var Subscription
     *
     * @ORM\OneToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Subscription",
     * mappedBy="user"
     * )
     */
    private $subscriptions;

    /**
     * @var Parcel
     *
     * @ORM\OneToMany(
     * targetEntity="Koopa\Bundle\JobBundle\Entity\Parcel",
     * mappedBy="author",
     * cascade={"remove"}
     * )
     * @ORM\JoinColumn(nullable=true)
     */
    private $parcels;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->enabled       = true;
        $this->jobs          = new ArrayCollection();
        $this->skills        = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->parcels       = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        if ($this->firstname and $this->lastname) {
            return ucfirst($this->lastname) . " " .  ucfirst($this->firstname);
        } else {
            return ucfirst($this->username);
        }
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
     * Add jobs
     *
     * @param Job $jobs
     * @return User
     */
    public function addJob(Job $jobs)
    {
        $this->jobs[] = $jobs;
        $jobs->setUser($this);

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param Job $jobs
     */
    public function removeJob(Job $jobs)
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
     * Add skills
     *
     * @param Skill $skills
     * @return User
     */
    public function addSkill(Skill $skills)
    {
        $this->skills[] = $skills;

        return $this;
    }

    /**
     * Remove skills
     *
     * @param Skill $skills
     */
    public function removeSkill(Skill $skills)
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
     * Add subscriptions
     *
     * @param Subscription $subscriptions
     * @return User
     */
    public function addSubscription(Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;
        $subscriptions->setUser($this);

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param Subscription $subscriptions
     */
    public function removeSubscription(Subscription $subscriptions)
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
     * Set image
     *
     * @param Image $image
     * @return User
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @ORM\PreUpdate()
     * @param LifecycleEventArgs $e
     */
    public function preUpdate(LifecycleEventArgs $e)
    {
        $user = $e->getObject();
        $image = $user->getImage();

        if ($image instanceof Image) {
            if ($image->getId() && null === $image->getExtension()) {
                $user->setImage(null);
            }
        }
    }

    /**
     * Add parcel
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Parcel $parcel
     *
     * @return User
     */
    public function addParcel(\Koopa\Bundle\JobBundle\Entity\Parcel $parcel)
    {
        $this->parcels[] = $parcel;

        return $this;
    }

    /**
     * Remove parcel
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Parcel $parcel
     */
    public function removeParcel(\Koopa\Bundle\JobBundle\Entity\Parcel $parcel)
    {
        $this->parcels->removeElement($parcel);
    }

    /**
     * Get parcels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    public function convert()
    {
        $data = [];
        $data['username'] = $this->username;
        $data['email'] = $this->email;
        $data['firstname'] = $this->firstname;
        $data['lastname'] = $this->lastname;
        $data['gender'] = $this->gender;

        return $data;
    }

    public function __toString()
    {
        return sprintf(
            'Personne %s %s %s',
            $this->username,
            $this->firstname,
            $this->lastname
        );
    }

    public function url()
    {
        return '';
    }
}

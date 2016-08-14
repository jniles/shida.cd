<?php

namespace Koopa\Bundle\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Parcel
 *
 * @ORM\Table(name="parcel")
 * @ORM\Entity(repositoryClass="Koopa\Bundle\JobBundle\Repository\ParcelRepository")
 */
class Parcel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="house_number", type="integer")
     */
    private $houseNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="for_sale", type="boolean")
     */
    private $forSale;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @var House[]
     *
     * @ORM\OneToMany(
     *     targetEntity="Koopa\Bundle\JobBundle\Entity\House",
     *     mappedBy="parcel",
     *     cascade={"persist"}
     * )
     */
    private $houses;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Koopa\Bundle\UserBundle\Entity\User", inversedBy="parcels")
     */
    private $author;

    /**
     * @var Address
     *
     * @ORM\OneToOne(
     *     targetEntity="Koopa\Bundle\JobBundle\Entity\Address",
     *     cascade={"persist", "remove"}
     *  )
     */
    private $address;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->houses = new ArrayCollection();
        $this->forSale = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     *
     * @return Parcel
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return int
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set forSale
     *
     * @param boolean $forSale
     *
     * @return Parcel
     */
    public function setForSale($forSale)
    {
        $this->forSale = $forSale;

        return $this;
    }

    /**
     * Get forSale
     *
     * @return bool
     */
    public function getForSale()
    {
        return $this->forSale;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Parcel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add house
     *
     * @param \Koopa\Bundle\JobBundle\Entity\House $house
     *
     * @return Parcel
     */
    public function addHouse(\Koopa\Bundle\JobBundle\Entity\House $house)
    {
        $this->houses[] = $house;

        return $this;
    }

    /**
     * Remove house
     *
     * @param \Koopa\Bundle\JobBundle\Entity\House $house
     */
    public function removeHouse(\Koopa\Bundle\JobBundle\Entity\House $house)
    {
        $this->houses->removeElement($house);
    }

    /**
     * Get houses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHouses()
    {
        return $this->houses;
    }

    /**
     * Set author
     *
     * @param \Koopa\Bundle\UserBundle\Entity\User $author
     *
     * @return Parcel
     */
    public function setAuthor(\Koopa\Bundle\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        if (null !== $author) {
            $author->addParcel($this);
        }

        return $this;
    }

    /**
     * Get author
     *
     * @return \Koopa\Bundle\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set address
     *
     * @param \Koopa\Bundle\JobBundle\Entity\Address $address
     *
     * @return Parcel
     */
    public function setAddress(\Koopa\Bundle\JobBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Koopa\Bundle\JobBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
}
